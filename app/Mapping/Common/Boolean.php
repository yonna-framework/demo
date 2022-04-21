<?php

namespace App\Mapping\Common;

use Yonna\Mapping\Mapping;

class Boolean extends Mapping
{

    const true = 1;
    const false = -1;

    public function __construct()
    {
        self::setLabel(self::true, '是');
        self::setLabel(self::false, '否');
    }

}