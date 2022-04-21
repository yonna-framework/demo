<?php

namespace App\Mapping\League;

use Yonna\Mapping\Mapping;

class LeagueMemberPermission extends Mapping
{

    const JOINER = 1;
    const MANAGER = 5;
    const OWNER = 10;

    public function __construct()
    {
        self::setLabel(self::JOINER, '参与人');
        self::setLabel(self::MANAGER, '管理员');
        self::setLabel(self::OWNER, '拥有者');
    }

}