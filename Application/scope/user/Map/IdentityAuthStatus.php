<?php
/**
 * 会员身份认证状态
 */
namespace User\Map;


class IdentityAuthStatus extends \Common\Map\AbstractMap {

    const UN_CHECK   = -1;
    const UN_PASS   = -2;
    const CHECKING  = 1;
    const CHECKED   = 10;

    public function __construct(){
        $this->set(self::UN_CHECK         ,'未认证');
        $this->set(self::UN_PASS          ,'未通过认证');
        $this->set(self::CHECKING         ,'认证中');
        $this->set(self::CHECKED          ,'通过认证');
    }

}