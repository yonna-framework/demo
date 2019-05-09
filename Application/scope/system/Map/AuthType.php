<?php
/**
 * 验证类型
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2015/10/14
 * Time: 15:44
 */
namespace System\Map;


class AuthType extends \Common\Map\AbstractMap {

    const EMAIL      = 1;
    const MOBILE     = 2;

    const TOKEN      = 100;

    public function __construct(){
        $this->set(self::EMAIL  ,'邮箱');
        $this->set(self::MOBILE ,'手机');
        $this->set(self::TOKEN  ,'马甲码');
    }
}