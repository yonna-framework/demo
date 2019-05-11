<?php
namespace External\Map;
class WxmpAccountType extends \Common\Map\AbstractMap
{

    const dingyuehao = 'dingyuehao';
    const fuwuhao = 'fuwuhao';
    const qiyehao = 'qiyehao';

    public function __construct()
    {
        $this->set(self::dingyuehao, '订阅号');
        $this->set(self::fuwuhao, '服务号');
        $this->set(self::qiyehao, '企业号');
    }

}