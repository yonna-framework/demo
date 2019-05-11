<?php
namespace Data\Bean;

class DownloadBean extends \Common\Bean\AbstractBean{

    //type
    protected $id;                //int(12) unsigned NOT NULL
    protected $belong;            //tinyint(2) unsigned NOT NULL归属
    protected $name;              //varchar(50) NOT NULL下载文件名
    protected $introduce;         //varchar(100) NULL简介
    protected $description;       //varchar(255) NULL描述
    protected $pic;               //text NULL图片
    protected $dl_link;           //varchar(255) NULL下载链接
    protected $version;           //varchar(20) NULL版本
    protected $support;           //varchar(30) NULL使用支持
    protected $create_time;       //date NULL更新日期
    protected $update_time;       //date NULL更新日期

    //qty
    protected $dl_id;             //int(12) unsigned NOT NULL
    protected $dl_qty;            //int(10) unsigned NOT NULL下载次数
    protected $dl_last_time;      //datetime NULL最后一次下载时间

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBelong()
    {
        return $this->belong;
    }

    /**
     * @param mixed $belong
     */
    public function setBelong($belong)
    {
        $this->belong = $belong;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getIntroduce()
    {
        return $this->introduce;
    }

    /**
     * @param mixed $introduce
     */
    public function setIntroduce($introduce)
    {
        $this->introduce = $introduce;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * @param mixed $pic
     */
    public function setPic($pic)
    {
        $this->pic = $pic;
    }

    /**
     * @return mixed
     */
    public function getDlLink()
    {
        return $this->dl_link;
    }

    /**
     * @param mixed $dl_link
     */
    public function setDlLink($dl_link)
    {
        $this->dl_link = $dl_link;
    }

    /**
     * @return mixed
     */
    public function getDlQty()
    {
        return $this->dl_qty;
    }

    /**
     * @param mixed $dl_qty
     */
    public function setDlQty($dl_qty)
    {
        $this->dl_qty = $dl_qty;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * @param mixed $support
     */
    public function setSupport($support)
    {
        $this->support = $support;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @param mixed $create_time
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
    }

    /**
     * @return mixed
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    /**
     * @param mixed $update_time
     */
    public function setUpdateTime($update_time)
    {
        $this->update_time = $update_time;
    }

    /**
     * @return mixed
     */
    public function getDlId()
    {
        return $this->dl_id;
    }

    /**
     * @param mixed $dl_id
     */
    public function setDlId($dl_id)
    {
        $this->dl_id = $dl_id;
    }

    /**
     * @return mixed
     */
    public function getDlLastTime()
    {
        return $this->dl_last_time;
    }

    /**
     * @param mixed $dl_last_time
     */
    public function setDlLastTime($dl_last_time)
    {
        $this->dl_last_time = $dl_last_time;
    }

}