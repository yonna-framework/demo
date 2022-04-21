<?php

namespace App\Mapping\League;

use Yonna\Mapping\Mapping;

class LeagueIsAdmin extends Mapping
{

    const YES = 1;
    const NO = -1;

    public function __construct()
    {
        self::setLabel(self::YES, '是');
        self::setLabel(self::NO, '否');
    }

}