<?php
namespace Finance\Bean;
use Common\Bean\AbstractBean;

/**
 * Created by PhpStorm.
 * Date: 2018/01/15
 */

class WithdrawApplyBean extends AbstractBean{

    //apply
    protected $id;                    //id
    protected $uid;                   //bigint(20) unsigned NOT NULL用户ID
    protected $apply_amount;          //操作金额
    protected $last_handle_time;      //对于这个申请的最后一次处理时间
    protected $bank_card_id;          //银行卡ID
    protected $bank_card_info;        //银行卡信息
    protected $description;           //操作描述 | log
    protected $payPassword;           //支付密码
    protected $reason;                //char(255) NULL原因
    protected $status;                //tinyint(2) NOT NULL申请状态 -1不通过 1审核中 2审核通过 10提现完毕

    //member-info
    protected $real_name;             //真实姓名
    protected $identity_auth_status;  //实名认证状态

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
    public function getApplyAmount()
    {
        return $this->apply_amount;
    }

    /**
     * @param mixed $apply_amount
     */
    public function setApplyAmount($apply_amount)
    {
        $this->apply_amount = $apply_amount;
    }

    /**
     * @return mixed
     */
    public function getLastHandleTime()
    {
        return $this->last_handle_time;
    }

    /**
     * @param mixed $last_handle_time
     */
    public function setLastHandleTime($last_handle_time)
    {
        $this->last_handle_time = $last_handle_time;
    }

    /**
     * @return mixed
     */
    public function getBankCardId()
    {
        return $this->bank_card_id;
    }

    /**
     * @param mixed $bank_card_id
     */
    public function setBankCardId($bank_card_id)
    {
        $this->bank_card_id = $bank_card_id;
    }

    /**
     * @return mixed
     */
    public function getBankCardInfo()
    {
        return $this->bank_card_info;
    }

    /**
     * @param mixed $bank_card_info
     */
    public function setBankCardInfo($bank_card_info)
    {
        $this->bank_card_info = $bank_card_info;
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
    public function getPayPassword()
    {
        return $this->payPassword;
    }

    /**
     * @param mixed $payPassword
     */
    public function setPayPassword($payPassword)
    {
        $this->payPassword = $payPassword;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     * @param mixed $real_name
     */
    public function setRealName($real_name)
    {
        $this->real_name = $real_name;
    }

    /**
     * @return mixed
     */
    public function getIdentityAuthStatus()
    {
        return $this->identity_auth_status;
    }

    /**
     * @param mixed $identity_auth_status
     */
    public function setIdentityAuthStatus($identity_auth_status)
    {
        $this->identity_auth_status = $identity_auth_status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}