<?php
/**
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2017/12/21
 */
namespace Data\Map;


class DownloadBelong extends \Common\Map\AbstractMap {

    const WE_TOOL   = 1;
    const W3X       = 2;
    const DOM       = 3;

    public function __construct(){
        $this->set(self::WE_TOOL  ,'WE工具');
        $this->set(self::W3X      ,'w3x地图');
        $this->set(self::DOM      ,'电子文档');
    }

}