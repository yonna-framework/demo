<?php

namespace App\Scope;

use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Foundation\System;
use App\Helper\Assets;
use App\Helper\Image;
use Yonna\Response\Consequent\File;

/**
 * Class Xoss
 * @package App\Scope
 */
class Xoss extends AbstractScope
{

    const ASSET = '/xoss_download/';

    /**
     * @var string
     */
    private string $falseMsg = "";

    /**
     * @param $msg
     * @return bool
     */
    private function false($msg)
    {
        $this->falseMsg = $msg;
        return false;
    }

    /**
     * @param $data
     * @return array|bool
     */
    private function checkFileData($data)
    {
        if (!$data) {
            return $this->false("no file data");
        }
        // 检查是否上传失败
        if (!empty($data['error'])) {
            switch ($data['error']) {
                case '1':
                    $error = 'Maximum file size is ' . ini_get('upload_max_filesize');
                    break;
                case '2':
                    $error = 'Form size limit exceeded';
                    break;
                case '3':
                    $error = 'The file is damaged';
                    break;
                case '4':
                    $error = 'File missing';
                    break;
                case '6':
                    $error = 'No temporary file found';
                    break;
                case '7':
                    $error = 'File write failed';
                    break;
                case '999':
                default:
                    $error = 'Unknown mistake';
            }
            return $this->false($error);
        }
        // 检查文件名
        if (!$data['tmp_name']) {
            return $this->false("file name error");
        }
        // 检查临时文件是否已上传
        if (@is_uploaded_file($data['tmp_name']) === false) {
            return $this->false("upload fail");
        }
        // 获得文件扩展名
        $suffix = Assets::getSuffix($data['name'], $data['type']);
        if (!$suffix) {
            return $this->false('invalid suffix');
        }
        if (!Assets::checkExt($suffix)) {
            return $this->false('not allow suffix');
        }
        $data['suffix'] = $suffix;
        return $data;
    }

    /**
     * @param $fd
     * @return bool|mixed
     * @throws \Yonna\Throwable\Exception\DatabaseException
     */
    public function saveFile($fd)
    {
        $size = $fd['size'];
        $data = $fd['data'] ?? null;
        if (!$data) {
            if ($size > 0) {
                $data = file_get_contents($fd['tmp_name']);
                if (!$data) {
                    return $this->false('invalid tmp data');
                }
            } else {
                $data = '';
            }
        }
        $saveData = [
            'name' => $fd['name'],
            'suffix' => $fd['suffix'],
            'size' => $fd['size'],
            'content_type' => $fd['type'],
        ];
        $root = $this->request()->getCargo()->getRoot();
        $md5 = md5($data);
        $sha1 = sha1($data);
        $hash = $sha1 . $md5;
        // 检查文件是否已存在
        $fileData = DB::connect()->table('xoss')
            ->field('key,name,suffix,size,content_type,uri')
            ->where(fn(Where $w) => $w->equalTo('hash', $hash))
            ->one();
        if (!$fileData || !is_file($root . $fileData['xoss_uri'])) {
            $saveData['hash'] = $hash;
            $saveData['key'] = $hash; // 这个key用于访问资源，默认是hash
            $saveData['md5_name'] = $md5;
            $saveData['path'] = '/uploads/' . date('Y-m-d') . "/" . date('H') . "/";
            $saveData['uri'] = $saveData['path'] . $md5 . '.' . $fd['suffix'];
            if (!System::dirCheck($root . $saveData['path'], true)) {
                return $this->false('invalid dir');
            }
            if (!is_file($root . $saveData['uri'])) {
                $size = @file_put_contents($root . $saveData['uri'], $data);
                if ($size === false) {
                    return $this->false('save failed');
                }
            }
            if ($this->request()->getLoggingId()) {
                $saveData['user_id'] = $this->request()->getLoggingId();
            }
        }
        if (!$fileData) {
            DB::connect()->table('xoss')->insert($saveData);
            $fileData = DB::connect()->table('xoss')
                ->field('key,name,suffix,size,content_type')
                ->where(fn(Where $w) => $w->equalTo('hash', $hash))
                ->one();
            if (!$fileData) {
                return $this->false('file data error');
            }
        }
        return $fileData;
    }

    private function analysisFile()
    {
        $files = $this->request()->getFiles();
        $results = [];
        foreach ($files as $fd) {
            $fd = $this->checkFileData($fd);
            if (!$fd) {
                $results[] = [
                    "result" => 0,
                    "msg" => $this->falseMsg,
                    "data" => null,
                ];
            } else {
                $data = $this->saveFile($fd);
                if (!$data) {
                    $results[] = [
                        "result" => 0,
                        "msg" => $this->falseMsg,
                        "data" => null,
                    ];
                } else {
                    $results[] = [
                        "result" => 1,
                        "msg" => 'success',
                        "data" => $data,
                    ];
                }
            }
        }
        return $results;
    }

    public function upload()
    {
        return $this->analysisFile();
    }

    /**
     * 按顺序访问~
     * $params[key]访键
     * $params[thumb]裁剪：thumb=500,500,1200,1200 (x1,y1,x2,y2) 坐标以左上角为(0,0)
     * $params[resize]缩放：100,100 | 100%,100% 支持百分比（urlencode=%25）及固定参数,height可省略
     * $params[flip]翻转：flip=0,1 (x,y) 支持0 or 1，1表示该轴翻转
     * $params[blur]模糊：blur=2 (distance)模糊程度，数值越大越模糊
     * $params[grayscale]灰度：grayscale=1 (1 or 0)
     * $params[reverse]反相 (1 or 0)
     * @return File
     * @throws \Yonna\Throwable\Exception\DatabaseException
     */
    public function download(): File
    {
        $rawData = null;
        $contentType = null;
        $fileName = null;
        $input = $this->request()->getInput();
        $params = $input['params'] ?? null;
        if ($params) {
            $params = urldecode($params[0]) ?? '';
            $params = explode('|', $params);

            $key = $params[0] ?? null;
            $thumb = $params[1] ?? null;
            $resize = $params[2] ?? null;
            $flip = $params[3] ?? null;
            $rotate = $params[4] ?? null;
            $blur = $params[5] ?? null;
            $grayscale = $params[6] ?? null;
            $reverse = $params[7] ?? null;

            if ($key) {
                $fileData = DB::connect()->table('xoss')->where(fn(Where $w) => $w->equalTo('key', $key))->one();
                if ($fileData) {
                    // 热度
                    DB::connect()->table('xoss')->where(fn(Where $w) => $w->equalTo('key', $key))->update([
                        'views' => $fileData['xoss_views'] + 1
                    ]);
                    //
                    $rawData = @file_get_contents($this->request()->getCargo()->getRoot() . $fileData['xoss_uri']);
                    $contentType = $fileData['xoss_content_type'];
                    $fileName = $fileData['xoss_name'];
                    // 图片处理(支持5种图片格式)
                    if (in_array($contentType, ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'])
                        && ($thumb || $resize || $flip || $rotate || $blur || $grayscale || $reverse)) {
                        $imageSource[] = imagecreatefromstring($rawData);
                        if ($imageSource[0] !== false) {
                            // 裁剪
                            if ($thumb) {
                                $thumbSplit = explode(",", $thumb);
                                $imageSource[] = Image::thumb($imageSource[0], $thumbSplit);
                                if (false !== $imageSource[1]) {
                                    array_shift($imageSource);
                                } else {
                                    array_pop($imageSource);
                                }
                            }
                            // 缩放
                            if ($resize) {
                                $resizeSplit = explode(",", $resize);
                                $imageSource[] = Image::resize($imageSource[0], $resizeSplit);
                                if (false !== $imageSource[1]) {
                                    array_shift($imageSource);
                                } else {
                                    array_pop($imageSource);
                                }
                            }
                            // 翻转
                            if ($flip) {
                                $flipSplit = explode(",", $flip);
                                if (isset($flipSplit[0]) && $flipSplit[0] == 1) {
                                    $imageSource[] = Image::flipX($imageSource[0]);
                                    if (false !== $imageSource[1]) {
                                        array_shift($imageSource);
                                    } else {
                                        array_pop($imageSource);
                                    }
                                }
                                if (isset($flipSplit[1]) && $flipSplit[1] == 1) {
                                    $imageSource[] = Image::flipY($imageSource[0]);
                                    if (false !== $imageSource[1]) {
                                        array_shift($imageSource);
                                    } else {
                                        array_pop($imageSource);
                                    }
                                }
                            }
                            // 旋转
                            if ($rotate) {
                                $rotate = round($rotate);
                                $imageSource[] = Image::rotate($imageSource[0], $rotate);
                                if (false !== $imageSource[1]) {
                                    array_shift($imageSource);
                                } else {
                                    array_pop($imageSource);
                                }

                            }
                            // 模糊
                            if ($blur && $blur > 0) {
                                $imageSource[] = Image::blur($imageSource[0], $blur);
                                if (false !== $imageSource[1]) {
                                    array_shift($imageSource);
                                } else {
                                    array_pop($imageSource);
                                }

                            }
                            // 灰度
                            if ($grayscale && $grayscale == 1) {
                                $imageSource[] = Image::grayscale($imageSource[0]);
                                if (false !== $imageSource[1]) {
                                    array_shift($imageSource);
                                } else {
                                    array_pop($imageSource);
                                }

                            }
                            // 色相反转
                            if ($reverse && $reverse == 1) {
                                $imageSource[] = Image::reverse($imageSource[0]);
                                if (false !== $imageSource[1]) {
                                    array_shift($imageSource);
                                } else {
                                    array_pop($imageSource);
                                }
                            }
                        }
                        if ($imageSource !== null) {
                            $imageSource = current($imageSource);
                            ob_start();
                            switch ($contentType) {
                                case 'image/jpeg':
                                    imagejpeg($imageSource);
                                    break;
                                case 'image/png':
                                    imagepng($imageSource);
                                    break;
                                case 'image/gif':
                                    imagegif($imageSource);
                                    break;
                                case 'image/bmp':
                                    imagebmp($imageSource);
                                    break;
                                case 'image/webp':
                                    imagewebp($imageSource);
                                    break;
                            }
                            $rawData = ob_get_contents();
                            ob_end_clean();
                            imagedestroy($imageSource);
                        }
                    }
                }
            }
        }
        return (new File($rawData, $contentType, $fileName));
    }

}