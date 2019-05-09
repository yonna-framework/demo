<?php
/**
 * 码制
 * Date: 2018/05/15
 */
namespace Common\Map;


class CodeComplex extends AbstractMap {

    const NUM           = 'num';
    const LOWER_LETTER  = 'lower_letter';
    const UPPER_LETTER  = 'upper_letter';
    const MIX_LETTER    = 'mix_letter';
    const MIX_ALL       = 'mix_all';

    public function __construct(){

        $this->set(self::NUM            ,'纯数字');
        $this->set(self::LOWER_LETTER   ,'小写字母');
        $this->set(self::UPPER_LETTER   ,'大写字母');
        $this->set(self::MIX_LETTER     ,'混合字母');
        $this->set(self::MIX_ALL        ,'混合大小字母数字');

    }
}