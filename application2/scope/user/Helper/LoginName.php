<?php
/**
 * @date: 2018/06/08
 */
namespace User\Helper;

use Common\Helper\AbstractHelper;

class LoginName extends AbstractHelper{

    const default_name = 'U';
    const delete_name = 'D';
    const NameLength = 20;		//建议数据库最大长度一致
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
	public function checkName($name){
		if(!$name) return $this->false('缺少个性登录名');
		// if(isMobile($name)) return $this->false('不可填写手机号码');
		if(isEmail($name)) return $this->false('不可填写邮箱地址');

		//检测禁止库
		foreach(self::banList as $bl){
			if(strpos(strtolower($name),$bl)!==false){
				return $this->false('被禁止的名称');
			}
		}

		$length 		= strlen($name);
		$onlyNum		= (floor($name)>0 && floor($name) == $name) ? true :false;
		$firstCharIsNum = floor(mb_substr($name,0,1,'utf-8')) > 0 ? true : false;
		$haveBlank 		= (preg_match('/\s+/',$name)) ? true : false;
		$haveCharacter	= (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$name)) ? true : false;
		$haveSymbol 	= (preg_match("/[ '.,:;*?、？·~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$name)) ? true : false;

		if($length<3) 		return $this->false('个性登录名要不小于3个字符');
		if($length>20) 		return $this->false('个性登录名不得大于20个字符');
		// if($firstCharIsNum)	return $this->false('个性登录名不能以数字开头');
		// if($onlyNum)		return $this->false('个性登录名不能纯数字');
		if($haveBlank)  	return $this->false('个性登录名不能包含空格');
		if($haveCharacter)	return $this->false('个性登录名不能有中文字');
		if($haveSymbol)  	return $this->false('个性登录名不能含有符号');
		return true;
	}

	/**
	 * 创建默认登录名
	 * @return string
	 */
	public function createDefaultName(){
		$str1 = self::default_name;
		$str1len = strlen($str1);
		$str2 = str_replace('.','',microtime(true));
        $str2len = strlen($str2);
		$str3len = self::NameLength - $str1len - $str2len;
		return $str1.$str2.randCharNum($str3len);
	}

	/**
	 * 创建被删除的登录名
	 * @return string
	 */
	public function createDeleteName(){
		$str1 = self::delete_name;
		$str1len = strlen($str1);
		$str2 = str_replace('.','',microtime(true));
        $str2len = strlen($str2);
		$str3len = self::NameLength - $str1len - $str2len;
		return $str1.$str2.randCharNum($str3len);
	}

}