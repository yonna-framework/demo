<?php
namespace Order\Map;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/16
 * Time: 22:04
 */

class PayStatus extends \Common\Map\AbstractMap{

    const UNPAY            = -1;    //未支付
    const PAYED            =  5;    //已支付
    const COD              = 10;    //货到付款
    const FREE             = 11;    //免费的

    public function __construct() {
        $this->set(self::UNPAY,     '未支付');
        $this->set(self::PAYED,     '已支付');
        $this->set(self::COD,       '货到付款');
        $this->set(self::FREE,      '免费的');
    }
}