<?php
//时间单位

namespace App\Mapping\Common;

use Yonna\Mapping\Mapping;

class DateTimeUnit extends Mapping
{

    const year = 'year';
    const month = 'month';
    const week = 'week';
    const day = 'day';
    const hour = 'hour';
    const minute = 'minute';
    const second = 'second';

    public function __construct()
    {
        self::setLabel(self::year, '年');
        self::setLabel(self::month, '月');
        self::setLabel(self::week, '周');
        self::setLabel(self::day, '日');
        self::setLabel(self::hour, '小时');
        self::setLabel(self::minute, '分钟');
        self::setLabel(self::minute, '秒');
    }

}