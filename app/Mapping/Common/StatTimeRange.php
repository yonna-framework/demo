<?php

namespace App\Mapping\Common;


use Yonna\Mapping\Mapping;

class StatTimeRange extends Mapping
{

    const Y = 'y';
    const M = 'm';
    const D = 'd';
    const H = 'h';
    const I = 'i';
    const S = 's';

    public function __construct()
    {
        self::setLabel(self::Y, '按年');
        self::setLabel(self::M, '按月');
        self::setLabel(self::D, '按日');
        self::setLabel(self::H, '按时');
        self::setLabel(self::I, '按分');
        self::setLabel(self::S, '按秒');
    }

}