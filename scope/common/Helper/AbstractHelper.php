<?php
/**
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2017/12/20
 */

namespace Common\Helper;

class AbstractHelper{

    private $false = '';

    /**
     * 设置错误
     * @param $err
     * @return bool
     */
    public function false($err){
        $this->false = $err;
        return false;
    }

    /**
     * 获取错误
     * @return string
     */
    public function getFalseMsg(){
        return $this->false;
    }

}