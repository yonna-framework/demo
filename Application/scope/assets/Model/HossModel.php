<?php

namespace Assets\Model;

class HossModel extends AbstractModel
{

    /**
     * @return \Assets\Bean\HossBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * @param $data
     * @return array|bool
     */
    private function checkFileData($data)
    {
        if (!$data) {
            return $this->false('check file data error');
        }
        // 检查是否上传失败
        if (!empty($data['error'])) {
            switch ($data['error']) {
                case '1':
                    $error = 'out of size in .ini';
                    break;
                case '2':
                    $error = 'out of form size';
                    break;
                case '3':
                    $error = 'file is damaged';
                    break;
                case '4':
                    $error = 'file lose';
                    break;
                case '6':
                    $error = 'temp file not found';
                    break;
                case '7':
                    $error = 'hard disk error';
                    break;
                case '8':
                    $error = 'aborted by extended file upload';
                    break;
                case '999':
                default:
                    $error = 'unknow';
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
        $ext = $this->assetsHelper()->getExtByFileName($data['name']);
        if (!$ext) $ext = $this->assetsHelper()->getExtByMime($data['type']);
        if (!$ext) return $this->false('invalid ext');
        if (!$this->assetsHelper()->checkExt($ext)) {
            return $this->false('not allow ext');
        }
        $data['ext'] = $ext;

        // 检查level
        if ($this->getBean()->isCheckLevel()) {
            $levelInfo = $this->getUserCallLevel($this->getBean()->getAuthUid(), $ext, $data['size']);
            if (!$levelInfo) {
                return $this->false($this->getFalseMsg());
            }
        }
        return $data;
    }

    /**
     * 获取 HTML 数据 source 将数据转为路径后 返回新的 html
     * @param $html
     * @return string
     */
    public function getHtmlDataSource__($html)
    {
        if (!$html) return $html;
        $src = $this->assetsHelper()->getHtmlSource($html);
        if (!$src) return $html;
        if(is_array($src)){
            foreach ($src as $k => $fd) {
                $hash = $this->assetsHelper()->getFileHashByBin($fd['data']);
                $hashId = $hash[2];
                if (!$hashId) return $this->false('hash fail');

                $dir = $hash[0];
                $hash_file_name = $hashId . '.' . $fd['ext'];
                $download_url = $hash[1] . $hash_file_name;
                $filename = (!empty($fd['name']) ? $fd['name'] : $hashId) . '.' . $fd['ext'];

                $dir = dirCheck($dir, true);
                if (!$dir) return $this->false('dir not exist');

                if (!is_file($dir . $hash_file_name)) {
                    $size = @file_put_contents($dir . $hash_file_name, $fd['data']);
                    if ($size === false) {
                        return $this->false('can not save data to the path');
                    }
                } else {
                    $size = filesize($dir . $hash_file_name);
                }
                $fileData = $this->db()->table('assets')->equalTo('hash_id', $hashId)->one();
                if (!$fileData) {
                    $insertData = array(
                        'create_time' => $this->db()->now(),
                        'uid' => array($this->getBean()->getAuthUid()),
                        'hash_id' => $hashId,
                        'hash_file_name' => $hash_file_name,
                        'file_name' => $filename,
                        'file_ext' => $fd['ext'],
                        'file_size' => $size,
                        'content_type' => $fd['type'],
                        'from_url' => "html_source",
                        'download_url' => $download_url,
                        'path' => $dir . $hash_file_name,
                    );
                    try {
                        $this->db()->table('assets')->insert($insertData);
                    } catch (\Exception $e) {
                        return $this->false($e->getMessage());
                    }
                    $fileData = $this->db()->table('assets')->equalTo('hash_id', $hashId)->one();
                    if (!$fileData) {
                        return $this->false('file data error');
                    }
                }
                if (!in_array($this->getBean()->getAuthUid(), $fileData['assets_uid'])) {
                    $fileData['assets_uid'][] = $this->getBean()->getAuthUid();
                    $fileData['assets_uid'] = array_unique($fileData['assets_uid']);
                    $updateData = array(
                        'uid' => $fileData['assets_uid'],
                        'update_time' => $this->db()->now(),
                    );
                    try {
                        $this->db()->table('assets')->equalTo('hash_id', $hashId)->update($updateData);
                    } catch (\Exception $e) {
                    }
                }
                // $fileData['assets_error'] = 0;
                // $fileData['assets_file_image'] = $this->getHost() . $this->assetsHelper()->getImageByContentType($fileData['assets_file_ext'], $fileData['assets_download_url']);
                // $fileData['assets_download_url'] = $this->getHost() . $download_url;
                $html = str_replace($k, $this->getHost() . $download_url, $html);
            }
        }
        return $html;
    }

    /**
     * 上传单个处理
     * @param $fd
     * @return bool|mixed
     */
    private function uploadOne($fd)
    {
        $fd = $this->checkFileData($fd);
        if (!$fd) return $this->false($this->getFalseMsg());

        $size = $fd['size'];
        if ($size > 0) {
            $data = file_get_contents($fd['tmp_name']);
            if (!$data) return $this->false('invalid tmp data');
        } else {
            $data = '';
        }

        $hash = $this->assetsHelper()->getFileHashByBin($data);
        $hashId = $hash[2];
        if (!$hashId) return $this->false('hash fail');

        $dir = $hash[0];
        $hash_file_name = $hashId . '.' . $fd['ext'];
        $download_url = $hash[1] . $hash_file_name;
        $filename = $fd['name'] ?: $hashId . '.' . $fd['ext'];

        $dir = dirCheck($dir, true);
        if (!$dir) return $this->false('dir not exist');

        if (!is_file($dir . $hash_file_name)) {
            $size = @file_put_contents($dir . $hash_file_name, $data);
            if ($size === false) {
                return $this->false('can not save data to the path');
            }
        }
        $fileData = $this->db()->table('assets')->equalTo('hash_id', $hashId)->one();
        if (!$fileData) {
            $insertData = array(
                'create_time' => $this->db()->now(),
                'uid' => array($this->getBean()->getAuthUid()),
                'hash_id' => $hashId,
                'hash_file_name' => $hash_file_name,
                'file_name' => $filename,
                'file_ext' => $fd['ext'],
                'file_size' => $size,
                'content_type' => $fd['type'],
                'from_url' => $fd['tmp_name'],
                'download_url' => $download_url,
                'path' => $dir . $hash_file_name,
            );
            try {
                $this->db()->table('assets')->insert($insertData);
            } catch (\Exception $e) {
                return $this->false($e->getMessage());
            }
            $fileData = $this->db()->table('assets')->equalTo('hash_id', $hashId)->one();
            if (!$fileData) {
                return $this->false('file data error');
            }
        }
        if (!in_array($this->getBean()->getAuthUid(), $fileData['assets_uid'])) {
            $fileData['assets_uid'][] = $this->getBean()->getAuthUid();
            $updateData = array(
                'uid' => $fileData['assets_uid'],
                'update_time' => $this->db()->now(),
            );
            try {
                $this->db()->table('assets')->equalTo('hash_id', $hashId)->update($updateData);
            } catch (\Exception $e) {
            }
        }
        $fileData['assets_error'] = 0;
        $fileData['assets_file_image'] = $this->getHost() . $this->assetsHelper()->getImageByContentType($fileData['assets_file_ext'], $fileData['assets_download_url']);
        $fileData['assets_download_url'] = $this->getHost() . $download_url;
        unset($fileData['assets_uid']);
        unset($fileData['assets_hash_id']);
        unset($fileData['assets_path']);
        unset($fileData['assets_from_url']);
        unset($fileData['assets_call_qty']);
        unset($fileData['assets_call_last_time']);
        unset($fileData['assets_create_time']);
        unset($fileData['assets_update_time']);
        return $fileData;
    }

    /**
     * @return array
     */
    public function upload()
    {
        if (!$this->getFiles()) {
            return $this->error('not files');
        }
        $result = array();
        foreach ($this->getFiles() as $fd) {
            $tmp = $this->uploadOne($fd);
            if (!$tmp) {
                $result[] = array(
                    'assets_error' => $this->getFalseMsg(),
                    'assets_file_name' => $fd['name'],
                    'assets_file_size' => $fd['size'],
                    'assets_content_type' => $fd['type'],
                );
            } else $result[] = $this->uploadOne($fd);
        }
        return $this->success($result);
    }

}