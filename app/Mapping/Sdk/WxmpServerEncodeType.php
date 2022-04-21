<?php

namespace App\Mapping\Sdk;

use Yonna\Mapping\Mapping;

class WxmpServerEncodeType extends Mapping
{

    const plaintext = 'plaintext';
    const compatible = 'compatible';
    const security = 'security';

    public function __construct()
    {
        self::setLabel(self::plaintext, '明文模式（明文模式下，不使用消息体加解密功能，安全系数较低）');
        self::setLabel(self::compatible, '兼容模式（兼容模式下，明文、密文将共存，方便开发者调试和维护）');
        self::setLabel(self::security, '安全模式（ * 推荐，安全模式下，消息包为纯密文，需要开发者加密和解密，安全系数高）');
    }

}