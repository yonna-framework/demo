<?php
/**
 * 提现申请状态类型
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2015/12/03
 * Time: 15:56
 */

namespace Finance\Map;


class WithdrawApplyStatus extends \Common\Map\AbstractMap{

    const UNVERIFY  = 1;    //审核中
    const PASS      = 2;    //通过
    const UNPASS    = -1;   //未通过
    const OVER      = 10;   //完成

    public function __construct(){
        $this->set(self::UNVERIFY     ,'审核中');
        $this->set(self::PASS         ,'通过');
        $this->set(self::UNPASS       ,'未通过');
        $this->set(self::OVER         ,'完成');
    }

}