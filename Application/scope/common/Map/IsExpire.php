<?php

namespace Common\Map;


class IsExpire extends AbstractMap
{

    const yes = 1;
    const no = -1;
    const ready = -2;
    const unknow = -10;

    /**
     * 初始化数据
     */
    public function __construct()
    {
        $this->set(self::yes, '已过期');
        $this->set(self::no, '未过期');
        $this->set(self::ready, '准备过期');
        $this->set(self::unknow, '无记录');
    }
}
