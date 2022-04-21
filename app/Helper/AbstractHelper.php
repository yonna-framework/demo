<?php

namespace App\Helper;

class AbstractHelper
{

    private static string $false = '';

    /**
     * 设置错误
     * @param $err
     * @return bool
     */
    protected static function false($err)
    {
        self::$false = $err;
        return false;
    }

    /**
     * 获取错误
     * @return string
     */
    public static function getFalseMsg()
    {
        return self::$false;
    }

}