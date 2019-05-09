<?php
/**
 * 用户来源接口
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2018/06/27
 * Time: 18:24
 */

namespace User\Map;


class Source extends \Common\Map\AbstractMap{

    const OTHER     = 'other';
    const SYSTEM    = 'system';
    const ANDROID   = 'android';
    const APPLE     = 'apple';
    const WINDOWS   = 'windows';
    const WECHAT    = 'wechat';

    public function __construct(){
        $this->set(self::OTHER      ,'其他');
        $this->set(self::SYSTEM     ,'系统');
        $this->set(self::ANDROID    ,'安卓');
        $this->set(self::APPLE      ,'苹果');
        $this->set(self::WINDOWS    ,'微软');
        $this->set(self::WECHAT     ,'微信');
    }

}