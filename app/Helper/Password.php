<?php

namespace App\Helper;

class Password extends AbstractHelper
{

    const PWD_MIX = '|_hun!@#$++$!Zsig_1124'; //faa9a6ddddf57436961bf2d2bf4338df

    /**
     * 密码加密
     * @param $pwd
     * @return string
     */
    public static function parse($pwd)
    {
        return md5(self::PWD_MIX . $pwd);
    }

    /**
     * 检查密码安全性
     * @param $pwd
     * @return bool
     */
    public static function check($pwd)
    {
        if (!$pwd) return self::false('Please fill in the password');
        $length = strlen($pwd);
        // $haveNum = (preg_match('/\d+/', $pwd)) ? true : false;
        // $haveUpper = (preg_match('/[A-Z]+/', $pwd)) ? true : false;
        // $haveLower = (preg_match('/[a-z]+/', $pwd)) ? true : false;
        $haveBlank = (preg_match('/\s+/', $pwd)) ? true : false;
        if ($length < 4) return self::false('Password cannot be less than 4 digits');
        if ($length > 16) return self::false('Password cannot be greater than 16 digits');
        if ($haveBlank) return self::false('Password must not contain spaces');
        return true;
    }

    /**
     * 检测密码等级
     * 无码0级 一般的1-5级
     * @param $pwd
     * @return integer
     */
    public static function getLevel($pwd)
    {
        if ($pwd === null) return 0;
        $level = 1;
        $length = strlen($pwd);
        $haveNum = (preg_match('/\d+/', $pwd)) ? true : false;
        $haveUpper = (preg_match('/[A-Z]+/', $pwd)) ? true : false;
        $haveLower = (preg_match('/[a-z]+/', $pwd)) ? true : false;
        if ($length <= 6) $level--;   //小于6位-1分
        if ($haveNum) $level++;   //包含数字+1分
        if ($haveUpper) $level++;   //包含大写+1分
        if ($haveLower) $level++;   //包含小写+1分
        if ($length > 10) $level++;   //大于10位+1分
        return $level;
    }

    /**
     * 获取密码强度等级名称
     * @param int $level 1-5的数字
     * @return string
     */
    public static function getLevelName($level = null)
    {
        $name = array('危险', '低', '中', '较强', '强');
        return $name[$level];
    }

    /**
     * 获取密码等级色槽
     * @param null $safeLevel
     * @param int $LEVELS
     * @return array
     */
    public static function getLevelRGB($safeLevel = null, $LEVELS = 5)
    {
        $R = $G = $B = 204;     //默认灰色
        if ($safeLevel === null) {
            return array('R' => $R, 'G' => $G, 'B' => $B);
        }//默认
        $safeLevel++;
        //低安全三色(see http://rgb.phpddt.com/ by hunzsig)
        $lowR = 225;
        $lowG = 81;
        $lowB = 74;
        //高安全三色
        $uppR = 4;
        $uppG = 178;
        $uppB = 113;
        //每级阶度
        $gradientR = ($uppR - $lowR) / $LEVELS;
        $gradientG = ($uppG - $lowG) / $LEVELS;
        $gradientB = ($uppB - $lowB) / $LEVELS;
        if ($safeLevel == 1) {
            return array('R' => $lowR, 'G' => $lowG, 'B' => $lowB);
        }          //最低
        if ($safeLevel == $LEVELS) {
            return array('R' => $uppR, 'G' => $uppG, 'B' => $uppB);
        }    //最高
        return array(
            'R' => intval($lowR + $gradientR * $safeLevel),
            'G' => intval($lowG + $gradientG * $safeLevel),
            'B' => intval($lowB + $gradientB * $safeLevel),
        );
    }
}