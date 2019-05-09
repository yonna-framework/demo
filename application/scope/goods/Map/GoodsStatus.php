<?php
/**
 * @date: 2018/05/14
 */
namespace Goods\Map;

class GoodsStatus extends \Common\Map\AbstractMap {

    const yes   =   '1';
    const no    =   '-1';
    const del   =   '-10';

    public function __construct(){
        $this->set(self::yes,   '上架');
        $this->set(self::no,    '下架');
    }

}