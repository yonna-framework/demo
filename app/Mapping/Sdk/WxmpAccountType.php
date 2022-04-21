<?php

namespace App\Mapping\Sdk;

use Yonna\Mapping\Mapping;

class WxmpAccountType extends Mapping
{

    const dingyuehao = 'dingyuehao';
    const fuwuhao = 'fuwuhao';
    const qiyehao = 'qiyehao';

    public function __construct()
    {
        self::setLabel(self::dingyuehao, '订阅号');
        self::setLabel(self::fuwuhao, '服务号');
        self::setLabel(self::qiyehao, '企业号');
    }

}