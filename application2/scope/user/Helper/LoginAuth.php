<?php

/**
 * Author: hunzsig
 * Date: 2016/01/21
 */

namespace User\Helper;

use Common\Helper\AbstractHelper;

class LoginAuth extends AbstractHelper{

    const LOGIN_AUTH_MIX = '**20##177bb14135261#33';

	/**
	 * 生成验证密钥
	 * @param $ip
	 * @param $uuid
	 * @return string
	 */
	public function createAuthKey($ip,$uuid){
		if(!$ip) return $this->false('fail createAuthCodeI');
		if(!$uuid) return $this->false('fail createAuthCodeU');
		return md5($ip.$uuid);
	}

    /**
     * 合成检验码
     * @param $key
     * @return string
     */
	public function createAuthCode($key){
		if(!$key) return $this->false('fail createAuthCodeK');
		return md5($key.self::LOGIN_AUTH_MIX);
	}

	/**
	 * 对比检验码
	 * @param $authKey
	 * @param $authCode
	 * @return bool
	 */
	public function auth($authKey,$authCode){
		if(!$authKey) return $this->false('fail createAuthCodeAK');
		if(!$authCode) return $this->false('fail createAuthCodeAC');
		$thisCode = md5($authKey.self::LOGIN_AUTH_MIX);
		return ($thisCode == $authCode) ? true : $this->false('验证错误，请重试');
	}

}