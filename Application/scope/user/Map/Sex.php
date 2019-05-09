<?php
/**
 * 用户性别接口
 * @date: 2018/06/08
 */
namespace User\Map;


class Sex extends \Common\Map\AbstractMap{


    const UN_KNOW   ='-1';
    const MAN       = '1';
    const WOMEN     = '2';

    public function __construct(){
        $this->set(self::UN_KNOW   ,'未设置');
        $this->set(self::MAN       ,'男');
        $this->set(self::WOMEN     ,'女');
    }

}