<?php

namespace User\Bean;


class ShippingAddressBean extends \Common\Bean\AbstractBean {

    protected $id;                //bigint(20) unsigned NOT NULL地址id
    protected $uid;               //char(40) NOT NULL用户id
    protected $region;            //char(50) NOT NULL地区
    protected $address;           //char(255) NOT NULL具体地址
    protected $contact_user;      //char(10) NOT NULL联系人
    protected $contact_mobile;    //char(16) NOT NULL联系电话
    protected $tag;               //char(10) NULL自定义标签
    protected $is_default;        //tinyint(2) NOT NULL是否默认

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
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getContactUser()
    {
        return $this->contact_user;
    }

    /**
     * @param mixed $contact_user
     */
    public function setContactUser($contact_user)
    {
        $this->contact_user = $contact_user;
    }

    /**
     * @return mixed
     */
    public function getContactMobile()
    {
        return $this->contact_mobile;
    }

    /**
     * @param mixed $contact_mobile
     */
    public function setContactMobile($contact_mobile)
    {
        $this->contact_mobile = $contact_mobile;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getIsDefault()
    {
        return $this->is_default;
    }

    /**
     * @param mixed $is_default
     */
    public function setIsDefault($is_default)
    {
        $this->is_default = $is_default;
    }

}