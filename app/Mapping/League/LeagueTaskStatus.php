<?php

namespace App\Mapping\League;

use Yonna\Mapping\Mapping;

class LeagueTaskStatus extends Mapping
{

    const DELETE = -2;
    const REJECTION = -1;
    const PENDING = 1;
    const APPROVED = 2;
    const COMPLETE = 10;

    public function __construct()
    {
        self::setLabel(self::DELETE, '作废');
        self::setLabel(self::REJECTION, '申请驳回');
        self::setLabel(self::PENDING, '待审核');
        self::setLabel(self::APPROVED, '进行中');
        self::setLabel(self::COMPLETE, '完成');
    }

}