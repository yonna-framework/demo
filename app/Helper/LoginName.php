<?php

namespace App\Helper;

use Yonna\Foundation\Is;
use Yonna\Foundation\Str;

class LoginName extends AbstractHelper
{

    const default_name = 'U';
    const delete_name = 'D';
    const NameLength = 20;        //建议数据库最大长度一致
    const banList = array(
        'json',
        'admin',
        'root',
        'guanliyuan',
        'fuck',
        'shit',
        'hunzsig',
        'hjass',
    );


    /**
     * 检查个性登录名
     * @param $name
     * @return bool
     */
    public static function check($name)
    {
        if (!$name) return self::false('not login name');
        if (Is::mobile($name)) return self::false('login name shall not be phone number');
        if (Is::email($name)) return self::false('login name shall not be email');

        //检测禁止库
        foreach (self::banList as $bl) {
            if (strpos(strtolower($name), $bl) !== false) {
                return self::false('Because it is unsafe, the name is forbidden to be used again');
            }
        }

        $length = strlen($name);
        // $onlyNum = (floor($name) > 0 && floor($name) == $name) ? true : false;
        // $firstCharIsNum = floor(mb_substr($name, 0, 1, 'utf-8')) > 0 ? true : false;
        $haveBlank = (preg_match('/\s+/', $name)) ? true : false;
        $haveCharacter = (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $name)) ? true : false;
        $haveSymbol = (preg_match("/[ '.,:;*?、？·~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $name)) ? true : false;

        if ($length < 3) return self::false('login name shall not be less than 3 characters');
        if ($length > 20) return self::false('login name shall not be longer than 20 characters');
        if ($haveBlank) return self::false('login name shall not has block');
        if ($haveCharacter) return self::false('login name shall not has Chinese');
        if ($haveSymbol) return self::false('login name shall not has Symbol');
        return true;
    }

    /**
     * 创建默认登录名
     * @return string
     */
    public static function createDefault()
    {
        $str1 = self::default_name;
        $str1len = strlen($str1);
        $str2 = str_replace('.', '', microtime(true));
        $str2len = strlen($str2);
        $str3len = self::NameLength - $str1len - $str2len;
        return $str1 . $str2 . Str::randomNum($str3len);
    }

    /**
     * 创建被删除的登录名
     * @return string
     */
    public static function createDelete()
    {
        $str1 = self::delete_name;
        $str1len = strlen($str1);
        $str2 = str_replace('.', '', microtime(true));
        $str2len = strlen($str2);
        $str3len = self::NameLength - $str1len - $str2len;
        return $str1 . $str2 . Str::randomNum($str3len);
    }

}