<?php
/**
 * 钱包类型(同日志类型)
 * Created by PhpStorm.
 * Date: 2018/01/16
 */

namespace Finance\Map;


class WalletType extends \Common\Map\AbstractMap{

    const RECHARGE = 'recharge';
    const RECHARGE_BACKGROUND = 'recharge_background';
    const DEDUCT = 'deduct';
    const DEDUCT_BACKGROUND = 'deduct_background';
    const SHOPPING = 'shopping';

    const REGISTER_AWARD = 'register_award';

    const FREEZE = 'freeze';
    const UNFREEZE = 'unfreeze';
    const FREEZE_DEDUCT = 'freeze_deduct';

    const WITHDRAW_APPLY = 'withdraw_apply';
    const WITHDRAW_PASS = 'withdraw_pass';
    const WITHDRAW_REJECT = 'withdraw_reject';

    const ORDER_CANCEL = 'order_cancel';
    const REFUND_REIMBURSE = 'refund_reimburse';
    const REFUND_REJECT = 'refund_reject';

    const COMMISSION_RECHARGE_AWARD = 'commission_recharge_award';

    public function __construct(){

        $this->set(self::RECHARGE,                      '充值');
        $this->set(self::RECHARGE_BACKGROUND,           '后台充值');
        $this->set(self::DEDUCT,                        '扣款');
        $this->set(self::DEDUCT_BACKGROUND,             '后台扣款');
        $this->set(self::SHOPPING,                      '购物');

        $this->set(self::REGISTER_AWARD,                '注册奖励');

        $this->set(self::FREEZE,                        '冻结');
        $this->set(self::UNFREEZE,                      '解除冻结');
        $this->set(self::FREEZE_DEDUCT,                 '扣除冻结');

        $this->set(self::WITHDRAW_APPLY,                '提现申请');
        $this->set(self::WITHDRAW_PASS,                 '提现成功');
        $this->set(self::WITHDRAW_REJECT,               '提现不通过');

        $this->set(self::ORDER_CANCEL,                  '订单取消退款');
        $this->set(self::REFUND_REIMBURSE,              '售后退款');
        $this->set(self::REFUND_REJECT,                 '售后退货货款');

        $this->set(self::COMMISSION_RECHARGE_AWARD,     '充值奖励');

    }

}