<?php

namespace App\Mapping\Data;

use Yonna\Mapping\Mapping;

class DataStatus extends Mapping
{

    const DISABLED = -1;
    const ENABLED = 1;

    public function __construct()
    {
        self::setLabel(self::DISABLED, '无效');
        self::setLabel(self::ENABLED, '有效');
    }

}