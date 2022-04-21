<?php

namespace App\Mapping\User;

use Yonna\Mapping\Mapping;

class IdentityAuthStatus extends Mapping
{

    const REJECTION = -1;
    const PENDING = 1;
    const CHECKING = 2;
    const APPROVED = 10;

    public function __construct()
    {
        self::setLabel(self::REJECTION, '未通过认证');
        self::setLabel(self::PENDING, '待认证');
        self::setLabel(self::CHECKING, '认证中');
        self::setLabel(self::APPROVED, '已认证');
    }

}