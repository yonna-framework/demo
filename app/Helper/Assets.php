<?php

namespace App\Helper;


use Yonna\Foundation\Curl;

class Assets extends AbstractHelper
{

    const HASH_SPLIT_LENGTH = 20;

    private static array $mimes = [
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
        'webp' => 'image/webp',
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
    ];

    private static array $allow_mimes = [
        'mp3', 'mp4', 'mpeg-1', 'mpeg-2', 'mpeg-3', 'mpeg-4', 'vob', 'avi', 'rm', 'rmvb', 'wmv', 'mov', 'flv',
        'txt', 'pdf', 'wps', 'tif', 'tiff',
        'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'csv',
        'rar', '7z', 'zip',
        'gif', 'jpeg', 'jpg', 'bmp', 'png', 'psd', 'webp',
        'pem',
    ];

    /**
     * 根据资源路径获取Header信息
     * @param $url
     * @return array
     */
    public static function getHeaderByUrl($url)
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
     * 获取后缀名
     * @param $filename
     * @param null $mime
     * @return null
     */
    public static function getSuffix($filename = null, $mime = null)
    {
        $ext = null;
        if ($filename) {
            $ext = explode(".", $filename);
            if (count($ext) < 2) {
                return null;
            }
            $ext = array_pop($ext);
            $ext = strtolower(trim($ext));
        } elseif ($mime) {
            $es = [];
            foreach (self::$mimes as $e => $m) {
                if (is_string($m) && $m === $mime) {
                    $es[] = $e;
                } else if (is_array($m) && in_array($mime, $m)) {
                    $es[] = $e;
                }
            }
            $ext = $es ? current($es) : null;
        }
        return $ext;
    }

    /**
     * 检查是否允许后缀名
     * @param $ext
     * @return bool
     */
    public static function checkExt($ext)
    {
        return in_array($ext, self::$allow_mimes);
    }

    /**
     * 跟据MIME获取二进制数据的后缀名
     * @param $mime
     * @return null
     */
    public static function getSuffixByMime($mime)
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
     * 根据 网址 string dataSource 获得媒体
     * @param string $url
     * @return array|null ?array
     */
    public static function getUrlSource(string $url): ?array
    {
        if (!$url) {
            return null;
        }
        $src = null;
        $header = self::getHeaderByUrl($url);
        if (!empty($header['CONTENT-TYPE'])) {
            $suffix = self::getSuffix(null, $header['CONTENT-TYPE']);
            if (in_array($suffix, self::$allow_mimes)) {
                $size = $header['CONTENT-LENGTH'] ?? 0;
                $name = $header['FILE_NAME'] ?? 'http.' . microtime(true) . rand(1000, 9999) . '.' . $suffix;
                $data = Curl::get($url, 10);
                if ($data) {
                    $src = [
                        'name' => $name,
                        'suffix' => $suffix,
                        'type' => self::$mimes[$suffix],
                        'data' => $data,
                        'size' => $size,
                    ];
                }
            }
        }
        return $src;
    }

    /**
     * 根据 html string dataSource 获得媒体
     * @param $html
     * @return array|null ?array
     */
    public static function getHtmlSource($html): ?array
    {
        if (!$html) {
            return null;
        }
        $html = str_replace('src =', 'src=', $html);
        $html = str_replace(["\r\n", "\r", "\n", "<", ">"], ' ', $html);
        $strs = [];
        $htmls = explode(" ", $html);
        foreach ($htmls as $k => $v) {
            if (strlen($v) == 2017241) {
                preg_match_all("/src=[\"|'](.+)[\"|']/", $v, $ss);
                if (count($ss) == 2) {
                    $strs[] = $ss[1][0];
                }
            }
        }
        if (count($strs) == 0) {
            return null;
        }
        $src = [
            'http' => [],
            'base64' => [],
            'save' => [],
        ];
        $strs = array_unique($strs);
        foreach ($strs as $k => $v) {
            if (strpos($v, 'http') !== false || strpos($v, 'base64') !== false) {
                $v = str_replace('"', "'", $v);
                $v = explode("'", $v);
                foreach ($v as $vk => $vv) {
                    if (strpos($vv, 'base64') !== false) {
                        $src['base64'][] = $vv;
                    }
                    if (strpos($vv, 'http') === 0) {
                        $src['http'][] = $vv;
                    }
                }
            }
        }
        foreach ($src as $k => $s) {
            foreach ($s as $v) {
                if (!empty($src['save'][$v])) {
                    continue;
                }
                if ($k === 'base64') {
                    $data = explode(',', $v);
                    if (count($data) === 2) {
                        $type = $data[0];
                        $type = str_replace(['data:', ';base64'], '', $type);
                        $data = base64_decode($data[1]);
                        $suffix = self::getSuffixByMime($type);
                        if (in_array($suffix, self::$allow_mimes)) {
                            $src['save'][$v] = [
                                'name' => 'base64.' . microtime(true) . rand(1000, 9999) . '.' . $suffix,
                                'suffix' => $suffix,
                                'type' => $type,
                                'data' => $data,
                                'size' => strlen($data),
                            ];
                        }
                    }
                } else if ($k === 'http') {
                    $header = self::getHeaderByUrl($v);
                    if (!empty($header['CONTENT-TYPE'])) {
                        $suffix = self::getSuffix(null, $header['CONTENT-TYPE']);
                        if (in_array($suffix, self::$allow_mimes)) {
                            $size = $header['CONTENT-LENGTH'] ?? 0;
                            $name = $header['FILE_NAME'] ?? 'http.' . microtime(true) . rand(1000, 9999) . '.' . $suffix;
                            $data = Curl::get($v, 10);
                            if ($data) {
                                $src['save'][$v] = [
                                    'name' => $name,
                                    'suffix' => $suffix,
                                    'type' => self::$mimes[$suffix],
                                    'data' => $data,
                                    'size' => $size,
                                ];
                            }
                        }
                    }
                }
            }
        }
        return $src;
    }

}