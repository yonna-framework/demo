<?php
/**
 * Created by PhpStorm.
 * Date: 2018/05/09
 */
namespace User\Bean;

class WechatBean extends OnlineBean{

    protected $open_id; //微信 OPEN ID';
    protected $unionid; //微信 UNIONID';
    protected $sex; //微信性别 -1未设置1男2女';
    protected $nickname; //微信昵称';
    protected $login_name; //微信登录名';
    protected $avatar; //微信头像URL';
    protected $language; //微信客户端语言';
    protected $city; //微信所在城市';
    protected $province; //微信所在省';
    protected $country; //微信所在国家';

    protected $mobile;

    protected $emp_no;
    protected $emp_name;

    /**
     * @return mixed
     */
    public function getOpenId()
    {
        return $this->open_id;
    }

    /**
     * @param mixed $open_id
     */
    public function setOpenId($open_id): void
    {
        $this->open_id = $open_id;
    }

    /**
     * @return mixed
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     * @param mixed $unionid
     */
    public function setUnionid($unionid): void
    {
        $this->unionid = $unionid;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getLoginName()
    {
        return $this->login_name;
    }

    /**
     * @param mixed $login_name
     */
    public function setLoginName($login_name): void
    {
        $this->login_name = $login_name;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language): void
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province): void
    {
        $this->province = $province;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @param null $handle
     * @return mixed
     */
    public function getMobile($handle = null)
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getEmpNo()
    {
        return $this->emp_no;
    }

    /**
     * @param mixed $emp_no
     */
    public function setEmpNo($emp_no): void
    {
        $this->emp_no = $emp_no;
    }

    /**
     * @return mixed
     */
    public function getEmpName()
    {
        return $this->emp_name;
    }

    /**
     * @param mixed $emp_name
     */
    public function setEmpName($emp_name): void
    {
        $this->emp_name = $emp_name;
    }

}