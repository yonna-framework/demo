<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/5
 * Time: 8:19
 */

namespace Order\Map;


class OrderRefundType extends \Common\Map\AbstractMap {

    const REIMBURSE     = 'reimburse';      //退款（直接退钱）
    const REJECT        = 'reject';         //退货（退货才退钱）
    const REPLACE       = 'replace';        //换货
    const REPAIR        = 'repair';         //维修

    /**
     * 初始化数据
     */
    public function __construct() {
        $this->set(self::REIMBURSE,      '退款');
        $this->set(self::REJECT,         '退货');
        $this->set(self::REPLACE,        '换货');
        $this->set(self::REPAIR,         '维修');
    }
}
