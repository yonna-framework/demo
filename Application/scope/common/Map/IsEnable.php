<?php
/**
 * @date: 2017/02/01
 */
namespace Common\Map;


class IsEnable extends AbstractMap{

    const yes   =   '1';
    const no    =   '-1';
    const del   =   '-10';

    public function __construct(){
        $this->set(self::yes,'有效');
        $this->set(self::no,'无效');
    }

}