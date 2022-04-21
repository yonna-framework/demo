<?php

namespace App\Mapping\Essay;

use Yonna\Mapping\Mapping;

class EssayCategoryStatus extends Mapping
{

    const REJECTION = -1;
    const PENDING = 1;
    const APPROVED = 2;

    public function __construct()
    {
        self::setLabel(self::REJECTION, '审核驳回');
        self::setLabel(self::PENDING, '待审核');
        self::setLabel(self::APPROVED, '审核通过');
    }

}