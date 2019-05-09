<?php
namespace Goods\Bean;
/**
 * Created by PhpStorm.
 * @date: 2016/09/23
 */

class GoodsBrandBean extends \Common\Bean\AbstractBean{

    protected $id;
    protected $name;    //varchar(30) NOT NULL品牌名称
    protected $name_eng;//varchar(100) NULL品牌名称(英文)
    protected $country;       //varchar(50) NULL品牌国家
    protected $pic;    //char(255) NULL展示图片

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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNameEng()
    {
        return $this->name_eng;
    }

    /**
     * @param mixed $name_eng
     */
    public function setNameEng($name_eng): void
    {
        $this->name_eng = $name_eng;
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
    public function setPic($pic): void
    {
        $this->pic = $pic;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return strtolower($this->country);
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

}