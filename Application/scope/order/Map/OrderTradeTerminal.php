<?php
/**
 * 交易终端
 * Date: 2018/03/30
 */

namespace Order\Map;

class OrderTradeTerminal extends \Common\Map\AbstractMap {

    const NU_KNOW       = 'un_know';
    const ANDROID       = 'android';
    const IPHONE        = 'iphone';

    /**
     * 初始化数据
     */
    public function __construct() {
        $this->set(self::NU_KNOW,         '未知');
        $this->set(self::ANDROID,         '安卓');
        $this->set(self::IPHONE,          '苹果');
    }
}
