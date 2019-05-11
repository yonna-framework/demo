<?php
/**
 * 时间单位
 */
namespace Common\Map;

class DateTimeUnit extends AbstractMap{

    const year          = 'year';
    const month         = 'month';
    const week          = 'week';
    const day           = 'day';
    const hour          = 'hour';
    const minute        = 'minute';
    const second        = 'second';

    public function __construct(){
        $this->set(self::year,      '年');
        $this->set(self::month,     '月');
        $this->set(self::week,      '周');
        $this->set(self::day,       '日');
        $this->set(self::hour,      '小时');
        $this->set(self::minute,    '分钟');
        $this->set(self::minute,    '秒');
    }

}