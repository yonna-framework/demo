<?php
namespace System\Bean;

/**
 * Date: 2017/12/12
 */

class TipsI18nBean extends \Common\Bean\AbstractBean{

    protected $default;           //char(255) NOT NULL默认的提示
    protected $zh_cn;             //varchar(1024) NULL中国简中
    protected $zh_tw;             //varchar(1024) NULL台湾繁中
    protected $zh_hk;             //varchar(1024) NULL香港繁中
    protected $en_us;             //varchar(1024) NULL美国英语
    protected $ja_jp;             //varchar(1024) NULL日语
    protected $ko_kr;             //varchar(1024) NULL韩语

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return mixed
     */
    public function getZhCn()
    {
        return $this->zh_cn;
    }

    /**
     * @param mixed $zh_cn
     */
    public function setZhCn($zh_cn)
    {
        $this->zh_cn = $zh_cn;
    }

    /**
     * @return mixed
     */
    public function getZhTw()
    {
        return $this->zh_tw;
    }

    /**
     * @param mixed $zh_tw
     */
    public function setZhTw($zh_tw)
    {
        $this->zh_tw = $zh_tw;
    }

    /**
     * @return mixed
     */
    public function getZhHk()
    {
        return $this->zh_hk;
    }

    /**
     * @param mixed $zh_hk
     */
    public function setZhHk($zh_hk)
    {
        $this->zh_hk = $zh_hk;
    }

    /**
     * @return mixed
     */
    public function getEnUs()
    {
        return $this->en_us;
    }

    /**
     * @param mixed $en_us
     */
    public function setEnUs($en_us)
    {
        $this->en_us = $en_us;
    }

    /**
     * @return mixed
     */
    public function getJaJp()
    {
        return $this->ja_jp;
    }

    /**
     * @param mixed $ja_jp
     */
    public function setJaJp($ja_jp)
    {
        $this->ja_jp = $ja_jp;
    }

    /**
     * @return mixed
     */
    public function getKoKr()
    {
        return $this->ko_kr;
    }

    /**
     * @param mixed $ko_kr
     */
    public function setKoKr($ko_kr)
    {
        $this->ko_kr = $ko_kr;
    }

}