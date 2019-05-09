<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/5
 * Time: 8:19
 */

namespace Order\Map;


class OrderType extends \Common\Map\AbstractMap {

    const SHOPPING          = 'shopping';           //APP购物
    const CANTEEN_ORDER     = 'canteen_order';      //饭堂订餐
    const RECHARGE          = 'recharge';           //充值

    /**
     * 初始化数据
     */
    public function __construct() {
        $this->set(self::SHOPPING,          'APP商城购物');
        $this->set(self::CANTEEN_ORDER,     '饭堂订餐');
        $this->set(self::RECHARGE,          '充值');
    }
}
