<?php
/**
 * Date: 2018/05/09
 */
namespace Finance\Helper;

use Common\Helper\AbstractHelper;

class PayPassword extends AbstractHelper{

    const PWD_MIX = 'Ky666u!##+$!HWv_83314'; //123456 = 17cdff61ebf26e9e2f7cf7875d4888fd

	/**
	 * 密码加密
	 * @param $pwd
	 * @return string
	 */
	public function Password($pwd){
		return md5(self::PWD_MIX.$pwd);
	}

    /**
     * 检查支付密码安全性
     * @param $pwd
     * @return bool
     */
    public function checkPwd($pwd){
        if(!$pwd){
            return $this->false('请输入支付密码');
        }
        $length = strlen($pwd);
        if($length!=6){
            return $this->false('你需要输入6位的支付密码');
        }
        $haveLetter = (preg_match('/[A-Za-z]+/',$pwd)) ? true : false;
        $haveBlank = (preg_match('/\s+/',$pwd)) ? true : false;
        $haveCharacter	= (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$pwd)) ? true : false;
        if($haveLetter){
            return $this->false('支付密码只支持纯数字');
        }
        if($haveBlank){
            return $this->false('支付密码不得包含空格');
        }
        if($haveCharacter){
            return $this->false('支付密码不能有中文字');
        }
        return true;
    }

	/**
	 * 检测支付密码等级
	 * 无码0级 一般的1-5级
	 * @return integer
	 */
	public function getPwdLevel($pwd){
		if($pwd===null) return 0;
		$level = 1;
		$length = strlen($pwd);
		$haveNum = (preg_match('/\d+/',$pwd)) ? true : false;
		$haveUpper = (preg_match('/[A-Z]+/',$pwd)) ? true : false;
		$haveLower = (preg_match('/[a-z]+/',$pwd)) ? true : false;
		if($length<=6)  $level--;   //小于6位-1分
		if($haveNum)    $level++;   //包含数字+1分
		if($haveUpper)  $level++;   //包含大写+1分
		if($haveLower)  $level++;   //包含小写+1分
		if($length>10)  $level++;   //大于10位+1分
		return $level;
	}

	/**
	 * 获取支付密码强度等级名称
	 * @param int $level 1-5的数字
	 * @return string
	 */
	public function getPwdLevelName($level = null){
		$name = array('危险','低','中','较强','强');
		return $name[$level];
	}

	/**
	 * 获取支付密码等级色槽
	 * @return array
	 */
	public function getPwdLevelRGB($safeLevel=null,$LEVELS=5){
		$R = $G = $B = 204;     //默认灰色
		if($safeLevel===null){return array('R'=>$R,'G'=>$G,'B'=>$B);}//默认
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
		$gradientR = ($uppR - $lowR)/$LEVELS;
		$gradientG = ($uppG - $lowG)/$LEVELS;
		$gradientB = ($uppB - $lowB)/$LEVELS;
		if($safeLevel==1){return array('R'=>$lowR,'G'=>$lowG,'B'=>$lowB);}          //最低
		if($safeLevel==$LEVELS){return array('R'=>$uppR,'G'=>$uppG,'B'=>$uppB);}	//最高
		return array(
			'R'=>intval($lowR+$gradientR*$safeLevel),
			'G'=>intval($lowG+$gradientG*$safeLevel),
			'B'=>intval($lowB+$gradientB*$safeLevel),
		);
	}
}