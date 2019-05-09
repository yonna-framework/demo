<?php
/**
 * 提现状态类型
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2015/12/03
 * Time: 15:56
 */

namespace Finance\Map;


class WithdrawStatus extends \Common\Map\AbstractMap{

    const ENABLE    = 1;    //可提现
    const DISABLE   = -1;   //不可提现

    public function __construct(){
        $this->set(self::ENABLE     ,'可提现');
        $this->set(self::DISABLE    ,'不可提现');
    }

}