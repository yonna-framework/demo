<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/16
 * Time: 22:07
 */
namespace Order\Map;


class FreightRuleType extends \Common\Map\AbstractMap {

    const free              = 'free';       //免运费
    const qty               = 'qty';        //按件数
    const weight            = 'weight';     //按重量
    const volume            = 'volume';     //按体积

    public function __construct(){
        //$this->set(self::free,           '免运费');
        $this->set(self::qty,              '按件数');
        $this->set(self::weight,           '按重量');
        $this->set(self::volume,           '按体积');
    }

}