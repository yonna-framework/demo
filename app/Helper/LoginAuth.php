<?php

namespace App\Helper;

class LoginAuth extends AbstractHelper
{

    const LOGIN_AUTH_MIX = '**20##177bb14135261#33';

    /**
     * 生成验证密钥
     * @param $ip
     * @param $uuid
     * @return string
     */
    public static function createAuthKey($ip, $uuid)
    {
        if (!$ip) return static::false('fail createAuthCodeI');
        if (!$uuid) return static::false('fail createAuthCodeU');
        return md5($ip . $uuid);
    }

    /**
     * 合成检验码
     * @param $key
     * @return string
     */
    public static function createAuthCode($key)
    {
        if (!$key) return static::false('fail createAuthCodeK');
        return md5($key . self::LOGIN_AUTH_MIX);
    }

    /**
     * 对比检验码
     * @param $authKey
     * @param $authCode
     * @return bool
     */
    public static function auth($authKey, $authCode)
    {
        if (!$authKey) return static::false('fail createAuthCodeAK');
        if (!$authCode) return static::false('fail createAuthCodeAC');
        $thisCode = md5($authKey . self::LOGIN_AUTH_MIX);
        return ($thisCode == $authCode) ? true : static::false('验证错误，请重试');
    }

}