<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/5
 * Time: 8:19
 */

namespace Order\Map;


class OrderTradePlace extends \Common\Map\AbstractMap {

    const NO_RECORD         = 'no_record';          //无记录
    const APP               = 'app';                //APP购买
    const WEIXIN            = 'weixin';             //微信购买

    /**
     * 初始化数据
     */
    public function __construct() {
        $this->set(self::NO_RECORD,           '无记录');
        $this->set(self::APP,                 'APP购买');
        $this->set(self::WEIXIN,              '微信购买');
    }
}
