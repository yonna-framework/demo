<?php
/**
 * 会员状态接口
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2015/9/22
 * Time: 15:44
 */

namespace User\Map;


class Status extends \Common\Map\AbstractMap{

    const FREEZE    = '-5';       //被冻结
    const UNVERIFY  = '-1';       //未审核
    const NORMAL    = '1';        //正常 | 通过审核
    const UNPASS    = '-2';       //未通过
    const DELETE    = '-10';      //被注销

    public function __construct(){
        $this->set(self::FREEZE      ,'已冻结');
        $this->set(self::UNVERIFY    ,'未审核');
        $this->set(self::NORMAL      ,'通过审核');
        $this->set(self::UNPASS      ,'未通过审核');
        $this->set(self::DELETE      ,'被注销');
    }

}