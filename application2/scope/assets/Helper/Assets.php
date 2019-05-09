<?php
/**
 * 图片处理机
 * Author: hunzsig
 * Date: 2018/08/17
 */

namespace Assets\Helper;

use Common\Helper\AbstractHelper;

class Assets extends AbstractHelper
{

    const HASH_SPLIT_LENGTH = 20;
    private static $mimes = array(
        'xl' => 'application/excel',
        'js' => ['application/javascript', 'application/x-javascript', 'text/javascript'],
        'hqx' => 'application/mac-binhex40',
        'cpt' => 'application/mac-compactpro',
        'bin' => 'application/macbinary',
        'doc' => 'application/msword',
        'word' => 'application/msword',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'class' => 'application/octet-stream',
        'dll' => 'application/octet-stream',
        'dms' => 'application/octet-stream',
        'exe' => 'application/octet-stream',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'psd' => 'application/octet-stream',
        'sea' => 'application/octet-stream',
        'so' => 'application/octet-stream',
        'oda' => 'application/oda',
        'pdf' => 'application/pdf',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'mif' => 'application/vnd.mif',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'wbxml' => 'application/vnd.wap.wbxml',
        'wmlc' => 'application/vnd.wap.wmlc',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'dxr' => 'application/x-director',
        'dvi' => 'application/x-dvi',
        'gtar' => 'application/x-gtar',
        'php3' => 'application/x-httpd-php',
        'php4' => 'application/x-httpd-php',
        'php' => 'application/x-httpd-php',
        'phtml' => 'application/x-httpd-php',
        'phps' => 'application/x-httpd-php-source',
        'swf' => 'application/x-shockwave-flash',
        'sit' => 'application/x-stuffit',
        'tar' => 'application/x-tar',
        'tgz' => 'application/x-tar',
        'xht' => 'application/xhtml+xml',
        'xhtml' => 'application/xhtml+xml',
        'zip' => 'application/zip',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'mpga' => 'audio/mpeg',
        'aif' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'ram' => 'audio/x-pn-realaudio',
        'rm' => 'audio/x-pn-realaudio',
        'rpm' => 'audio/x-pn-realaudio-plugin',
        'ra' => 'audio/x-realaudio',
        'wav' => 'audio/x-wav',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'png' => 'image/png',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'eml' => 'message/rfc822',
        'css' => 'text/css',
        'html' => 'text/html',
        'htm' => 'text/html',
        'shtml' => 'text/html',
        'log' => 'text/plain',
        'text' => 'text/plain',
        'txt' => 'text/plain',
        'rtx' => 'text/richtext',
        'rtf' => 'text/rtf',
        'vcf' => 'text/vcard',
        'vcard' => 'text/vcard',
        'xml' => 'text/xml',
        'xsl' => 'text/xml',
        'mpeg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mov' => 'video/quicktime',
        'qt' => 'video/quicktime',
        'rv' => 'video/vnd.rn-realvideo',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie'
    );
    private static $allow_mimes = array(
        'mp3', 'mp4', 'mpeg-1', 'mpeg-2', 'mpeg-3', 'mpeg-4', 'vob', 'avi', 'rm', 'rmvb', 'wmv', 'mov', 'flv',
        'txt', 'pdf', 'wps', 'tif', 'tiff',
        'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'csv',
        'rar', '7z', 'zip',
        'gif', 'jpeg', 'jpg', 'bmp', 'png', 'psd',
        'pem',
    );

    /**
     * 根据资源路径获取Header信息
     * @param $url
     * @return array
     */
    public function getHeaderByUrl($url)
    {
        if (!$url) return array();
        $header = get_headers($url);
        $hd = array(
            'HTTP_VERSION' => '',
            'HTTP_STATUS' => '',
            'HTTP_RESPONSE' => '',
            'FILE_NAME' => '',
        );
        foreach ($header as $h) {
            $h = urldecode($h);
            if (strpos($h, ':') === false) {
                if (strpos($h, 'HTTP') !== false) {
                    $h = explode(' ', $h);
                    $hd['HTTP_VERSION'] = array_shift($h);
                    $hd['HTTP_STATUS'] = array_shift($h);
                    $hd['HTTP_RESPONSE'] = implode(' ', $h);
                }
            } else {
                $h = explode(':', $h);
                $hd[strtoupper(trim($h[0]))] = trim($h[1]);
                if (preg_match("/filename=\"(.*)\"/i", $h[1], $pm)) {
                    $hd['FILE_NAME'] = trim(str_replace('/', '_', $pm[1]));
                } else if (preg_match("/filename=\'(.*)\'/i", $h[1], $pm)) {
                    $hd['FILE_NAME'] = trim(str_replace('/', '_', $pm[1]));
                } else if (preg_match("/filename=(.*)/i", $h[1], $pm)) {
                    $hd['FILE_NAME'] = trim(str_replace('/', '_', $pm[1]));
                }
            }
        }
        return $hd;
    }

    /**
     * 跟据MIME获取二进制数据的后缀名
     * @param $mime
     * @return null
     */
    public function getExtByMime($mime)
    {
        if (!$mime) return null;
        $ext = array();
        foreach (self::$mimes as $e => $m) {
            if (is_string($m) && $m === $mime) {
                $ext[] = $e;
            } else if (is_array($m) && in_array($mime, $m)) {
                $ext[] = $e;
            }
        }
        return $ext ? current($ext) : null;
    }

    /**
     * 跟据文件名获取后缀名
     * @param $filename
     * @return null
     */
    public function getExtByFileName($filename)
    {
        if (!$filename) return null;
        $ext = explode(".", $filename);
        if (count($ext) < 2) return null;
        $ext = array_pop($ext);
        $ext = strtolower(trim($ext));
        return $ext;
    }

    /**
     * 检查是否允许后缀名
     * @param $ext
     * @return bool
     */
    public function checkExt($ext)
    {
        return in_array($ext, self::$allow_mimes);
    }

    /**
     * 根据 Content-Type 获得图片路径
     * @param string $ext 后缀名
     * @param null $fileIsPicUrl
     * @return null
     */
    public function getImageByContentType($ext, $fileIsPicUrl = null)
    {
        if (in_array($ext, ['bmp', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'tiff', 'tif']) && $fileIsPicUrl) {
            return $fileIsPicUrl;
        }
        if (is_file(PATH_RESOURCE . DIRECTORY_SEPARATOR . 'image/contentType/' . $ext . '.png')) {
            return '/resource/image/contentType/' . $ext . '.png';
        } else {
            return '/resource/image/contentType/un.know.png';
        }
    }

    /**
     * 根据二进制数据，计算出应该保存在的 目录 / 地址 / 文件名Hash
     * @param $bin
     * @param int $compressLevel hash filename 目录根压缩等级，目录以 2 字符 1 层，默认 2 级(4层)，越高压缩效果越弱（越长），必须大于 0
     * @return array
     */
    public function getFileHashByBin($bin, int $compressLevel = 2)
    {
        if ($compressLevel < 1) $compressLevel = 1;
        $hash = hash('sha512', $bin);
        $hash = limit_convert($hash, 16);
        $fileHash = $hash;

        $hashBin = str2bin($hash);
        $compressExp = pow(2, $compressLevel) * 20;
        $dirHashStr = '';
        while (1) {
            if (strlen($hashBin) < $compressExp) {
                $dirHashStr = base_convert($hashBin, 2, 36);
                $powLength = pow(2, $compressLevel + 1);
                if (strlen($dirHashStr) < $powLength) {
                    $dirHashStr = str_pad($dirHashStr, $powLength, 0);
                } else if (strlen($dirHashStr) > $powLength) {
                    $dirHashStr = substr($dirHashStr, 0, $powLength);
                }
                break;
            }
            $s1 = substr($hashBin, 0, strlen($hashBin) * 0.5);
            $s2 = str_replace($s1, '', $hashBin);
            $max = max(strlen($s1), strlen($s2));
            $s1 = str_pad($s1, $max, 0);
            $s2 = str_pad($s2, $max, 0);
            $hashBin = $s1 xor $s2;
        }
        $dirHashStr = str_split($dirHashStr, 2);
        $dirHashStr = implode(DIRECTORY_SEPARATOR, $dirHashStr);
        $dir = PATH_UPLOAD . DIRECTORY_SEPARATOR . $dirHashStr . DIRECTORY_SEPARATOR;
        $url = '/uploads/' . str_replace(DIRECTORY_SEPARATOR, '/', $dirHashStr) . '/';
        return [$dir, $url, $fileHash];
    }

    /**
     * 根据 html string dataSource 获得媒体
     * @param $html
     * @return array
     */
    public function getHtmlSource($html)
    {
        if (!$html) {
            return $html;
        }
        preg_match_all("/src='(.*?)'/", $html, $a1);
        preg_match_all('/src="(.*?)"/', $html, $a2);
        $src = array();
        if (!empty($a1[1])) $src = array_merge($src, $a1[1]);
        if (!empty($a2[1])) $src = array_merge($src, $a2[1]);
        if (!$src) {
            return $html;
        }
        $src = array_unique($src);
        $new = array();
        foreach ($src as $v) {
            if (strpos($v,'http') === 0 || strpos($v,'base64') === false) {
                continue;
            }
            $data = explode(',', $v);
            if (count($data) === 2) {
                $type = $data[0];
                $type = str_replace(['data:', ';base64'], '', $type);
                $data = base64_decode($data[1]);
                list($width, $height) = getimagesize($v);
                $source = imagecreatefromstring($data);
                $new[$v] = array(
                    'ext' => $this->getExtByMime($type),
                    'type' => $type,
                    'data' => $data,
                    'width' => $width,
                    'height' => $height,
                    'source' => $source
                );
            }
        }
        return $new;
    }

    /**
     * 根据数据源、文件后缀名及真实路径，生成真实图片(最优质)
     * @param $source
     * @param $ext
     * @param $path
     * @return void
     */
    public function exportImage($source, $ext, $path)
    {
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($source, $path, 100);
                break;
            case 'png':
                imagepng($source, $path, 9);
                break;
            case 'gif':
                imagegif($source, $path);
                break;
            case 'bmp':
            case 'wbmp':
                imagewbmp($source, $path);
                break;
        }
    }

    /**
     * 上下翻转就是沿X轴翻转
     * @param $source
     * @return resource
     */
    public function imageScaleY($source)
    {
        $width = imagesx($source);
        $height = imagesy($source);
        $new = imagecreatetruecolor($width, $height);   //创建一个新的图片资源，用来保存沿Y轴翻转后的图片
        for ($y = 0; $y < $height; $y++) {                    //逐条复制图片本身高度，1个像素宽度的图片到新图层
            imagecopy($new, $source, 0, $height - $y - 1, 0, $y, $width, 1);
        }
        imagedestroy($source);
        return $new;
    }

    /**
     * 左右翻转就是沿Y轴翻转
     * @param $source
     * @return resource
     */
    public function imageScaleX($source)
    {
        $width = imagesx($source);
        $height = imagesy($source);
        $new = imagecreatetruecolor($width, $height);   //创建一个新的图片资源，用来保存沿Y轴翻转后的图片
        for ($x = 0; $x < $width; $x++) {                     //逐条复制图片本身高度，1个像素宽度的图片到新图层
            imagecopy($new, $source, $width - $x - 1, 0, $x, 0, 1, $height);
        }
        imagedestroy($source);
        return $new;
    }

}