<?php
namespace Order\Map;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/16
 * Time: 22:07
 */

class PayType extends \Common\Map\AbstractMap {

    const WALLET     = 'wallet';    //电子钱包
    const ALIPAY     = 'alipay';    //支付宝
    const WXPAY      = 'wxpay';     //微信支付

    public function __construct(){
        $this->set(self::WALLET,            '电子钱包');
        $this->set(self::ALIPAY,            '支付宝');
        $this->set(self::WXPAY,             '微信支付');
    }

}