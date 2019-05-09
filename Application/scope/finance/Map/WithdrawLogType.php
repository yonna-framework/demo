<?php
/**
 * 提现日志类型
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2015/12/03
 * Time: 15:56
 */

namespace Finance\Map;


class WithdrawLogType extends \Common\Map\AbstractMap{

    const WITHDRAW_APPLY    = 1;
    const WITHDRAW_PASS     = 2;
    const WITHDRAW_REJECT   = 3;
    const WITHDRAW_OVER     = 4;


    public function __construct(){
        $this->set(self::WITHDRAW_APPLY     ,'提现申请');
        $this->set(self::WITHDRAW_PASS      ,'提现通过');
        $this->set(self::WITHDRAW_REJECT    ,'提现被拒绝');
        $this->set(self::WITHDRAW_OVER      ,'提现交易完成');
    }

}