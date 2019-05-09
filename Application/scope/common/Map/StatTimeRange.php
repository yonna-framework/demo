<?php
/**
 * 表字段查询条件 - 时间范围
 * @date: 2016/12/26
 */
namespace Common\Map;


class StatTimeRange extends AbstractMap{

    const Y = 'y';
    const M = 'm';
    const D = 'd';
    const H = 'h';
    const I = 'i';
    const S = 's';

    public function __construct(){
        $this->set(self::Y,'按年');
        $this->set(self::M,'按月');
        $this->set(self::D,'按日');
        $this->set(self::H,'按时');
        $this->set(self::I,'按分');
        $this->set(self::S,'按秒');
    }

}