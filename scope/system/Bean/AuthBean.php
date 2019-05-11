<?php

namespace System\Bean;
/**
 * Date: 2018/10/15
 */
class AuthBean extends \Common\Bean\AbstractBean
{

    protected $id;
    protected $uid;
    protected $auth_name;
    protected $auth_code;
    protected $type;

    protected $complex;
    protected $length;
    protected $smsSendType;       //短信发送类型

    protected $email;
    protected $mobile;

    protected $external_config;

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
    public function getAuthName()
    {
        return $this->auth_name;
    }

    /**
     * @param mixed $auth_name
     */
    public function setAuthName($auth_name)
    {
        $this->auth_name = $auth_name;
    }

    /**
     * @return mixed
     */
    public function getAuthCode()
    {
        return $this->auth_code;
    }

    /**
     * @param mixed $auth_code
     */
    public function setAuthCode($auth_code)
    {
        $this->auth_code = $auth_code;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getComplex()
    {
        return $this->complex;
    }

    /**
     * @param mixed $complex
     */
    public function setComplex($complex)
    {
        $this->complex = $complex;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getSmsSendType()
    {
        return $this->smsSendType;
    }

    /**
     * @param mixed $smsSendType
     */
    public function setSmsSendType($smsSendType)
    {
        $this->smsSendType = $smsSendType;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getExternalConfig()
    {
        return $this->external_config;
    }

    /**
     * @param mixed $external_config
     */
    public function setExternalConfig($external_config): void
    {
        $this->external_config = $external_config;
    }

}