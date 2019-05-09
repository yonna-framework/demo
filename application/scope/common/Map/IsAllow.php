<?php
/**
 * Created by PhpStorm.
 * Date: 2018/05/14
 */
namespace Common\Map;

class IsAllow extends AbstractMap {

    const Yes       = '1';
    const No        ='-1';

    /**
     * 初始化数据
     */
    public function __construct()
    {
        $this->set(self::Yes,   '允许');
        $this->set(self::No,    '不允许');
    }
}
