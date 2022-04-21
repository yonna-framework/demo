<?php

namespace App\Mapping\User;

use Yonna\Mapping\Mapping;

class UserStatus extends Mapping
{

    const DELETE = -10;
    const FREEZE = -3;
    const REJECTION = -2;
    const PENDING = 1;
    const APPROVED = 2;

    public function __construct()
    {
        self::setLabel(self::DELETE, '注销');
        self::setLabel(self::FREEZE, '冻结');
        self::setLabel(self::REJECTION, '审核驳回');
        self::setLabel(self::PENDING, '待审核');
        self::setLabel(self::APPROVED, '审核通过');
    }

}