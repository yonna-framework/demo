<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/5
 * Time: 8:19
 */
namespace Order\Map;


class OrderRefundStatus extends \Common\Map\AbstractMap {

    const REFUND_APPLY  =   1;          //发起售后申请
    const REFUND_AGREE  =  10;          //同意售后申请
    const SENT          =  20;          //已寄回货物
    const RECEIVED      =  30;          //收到寄回货物
    const SENT_BACK     =  40;          //已处理并返回货物
    const FINISH        = 100;          //售后处理完成
    const CANCELED      = -10;          //已取消
    const AUTO_CANCEL   = -11;          //系统自动取消
    const REFUND_REJECT = -12;          //不同意售后申请


    /**
     * 初始化数据
     */
    public function __construct() {
        $this->set(self::REFUND_APPLY, '发起售后申请');
        $this->set(self::REFUND_AGREE, '申请已通过');
        $this->set(self::REFUND_REJECT, '不同意售后申请');
        $this->set(self::SENT, '已寄回货物');
        $this->set(self::RECEIVED, '收到寄回货物');
        $this->set(self::SENT_BACK, '已处理并返回货物');
        $this->set(self::FINISH, '售后处理完成');
        $this->set(self::CANCELED, '已取消');
        $this->set(self::AUTO_CANCEL, '系统超时取消');
    }

}
