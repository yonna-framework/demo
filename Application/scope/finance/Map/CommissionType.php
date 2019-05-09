<?php
/**
 * 业绩类型
 */
namespace Finance\Map;

class CommissionType extends \Common\Map\AbstractMap{

    const recharge_award = 'recharge_award';

    public function __construct(){

        $this->set(self::recharge_award, '充值奖励');

    }

}