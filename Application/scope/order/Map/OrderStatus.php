<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/5
 * Time: 8:19
 */

namespace Order\Map;

class OrderStatus extends \Common\Map\AbstractMap {

    const ORDERED               = 1;            //待支付
    const PAYED                 = 2;            //已支付/待发货
    const SENT                  = 10;           //已发货/待收货
    const RECEIVED              = 20;           //已收货/待评价
    const FINISH                = 100;          //已完成/已评价
    const CANCELED              = -10;          //已取消
    const AUTO_CANCEL           = -11;          //系统自动取消
    const AUTO_CANCEL_SELLER    = -14;          //卖家不发货，系统自动取消
    const REFUND_REIMBURSE      = -12;          //退款并结束
    const REFUND_REJECT         = -13;          //退货后退款并结束

    /**
     * 初始化数据
     */
    public function __construct() {
        $this->set(self::ORDERED, '待支付');
        $this->set(self::PAYED, '待发货');
        $this->set(self::SENT, '待收货');
        $this->set(self::RECEIVED, '待评价');
        $this->set(self::FINISH, '已完成');
        $this->set(self::CANCELED, '已取消');
        $this->set(self::AUTO_CANCEL, '系统超时取消');
        $this->set(self::AUTO_CANCEL_SELLER, '卖家不发货，系统超时取消');
        $this->set(self::REFUND_REIMBURSE, '退款并结束');
        $this->set(self::REFUND_REJECT, '退货后退款并结束');
    }
}
