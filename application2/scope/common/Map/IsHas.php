<?php
/**
 * @date: 2017/02/01
 */
namespace Common\Map;


class IsHas extends AbstractMap{

    const yes   =   '1';
    const no    =   '-1';

    public function __construct(){
        $this->set(self::yes,'有');
        $this->set(self::no,'无');
    }

}