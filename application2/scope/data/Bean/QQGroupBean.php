<?php
namespace Data\Bean;

class QQGroupBean extends \Common\Bean\AbstractBean{

    //type
    protected $id;                //int(12) unsigned NOT NULL
    protected $name;              //varchar(50) NOT NULLQQ群名
    protected $number;            //varchar(20) NULLQQ群号
    protected $build_year;        //varchar(100) NULLQQ群建立年
    protected $description;       //varchar(255) NULL描述
    protected $pic;               //text NULL图片
    protected $link;              //varchar(255) NULL加群链接
    protected $qty;               //int(4) NULL群里人员

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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getBuildYear()
    {
        return (int)$this->build_year;
    }

    /**
     * @param mixed $build_year
     */
    public function setBuildYear($build_year)
    {
        $this->build_year = $build_year;
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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getQty()
    {
        return (int)$this->qty;
    }

    /**
     * @param mixed $qty
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

}