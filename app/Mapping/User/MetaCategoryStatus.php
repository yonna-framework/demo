<?php

namespace App\Mapping\User;

use Yonna\Mapping\Mapping;

class MetaCategoryStatus extends Mapping
{

    const true = 1;
    const false = -1;

    public function __construct()
    {
        self::setLabel(self::true, '有效');
        self::setLabel(self::false, '无效');
    }

}