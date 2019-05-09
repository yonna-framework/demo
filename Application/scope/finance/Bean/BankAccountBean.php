<?php

namespace Finance\Bean;
use Common\Bean\AbstractBean;

/**
 * 银行帐号Bean
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2018/01/15
 * Time: 15:24
 */

class BankAccountBean extends AbstractBean{

    protected $id;
    protected $uid;               //会员id
    protected $account_bank_code; //开户银行代码
    protected $account_holder;    //银行帐号持有人
    protected $account_no;        //银行账户
    protected $account_type;      //帐号类型 1对公帐号 2对私帐号 3个人储蓄卡 4个人信用卡等
    protected $is_default;

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
    public function getAccountBankCode()
    {
        return $this->account_bank_code;
    }

    /**
     * @param mixed $account_bank_code
     */
    public function setAccountBankCode($account_bank_code)
    {
        $this->account_bank_code = $account_bank_code;
    }

    /**
     * @return mixed
     */
    public function getAccountHolder()
    {
        return $this->account_holder;
    }

    /**
     * @param mixed $account_holder
     */
    public function setAccountHolder($account_holder)
    {
        $this->account_holder = $account_holder;
    }

    /**
     * @return mixed
     */
    public function getAccountNo()
    {
        return $this->account_no;
    }

    /**
     * @param mixed $account_no
     */
    public function setAccountNo($account_no)
    {
        $this->account_no = $account_no;
    }

    /**
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->account_type;
    }

    /**
     * @param mixed $account_type
     */
    public function setAccountType($account_type)
    {
        $this->account_type = $account_type;
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