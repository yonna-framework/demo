<?php
namespace Finance\Bean;
use Common\Bean\AbstractBean;

/**
 * Created by PhpStorm.
 * Date: 2018/01/15
 */

class WalletBean extends AbstractBean{

    protected $id;
    protected $uid;                                   //uid
    protected $pay_password;                          //支付密码
    protected $pay_password_level;                    //支付密码等级
    protected $pay_password_confirm;                  //确认密码
    protected $status;                                //状态 1有效 -1无效
    protected $balance;                               //decimal(20,6) unsigned NOT NULL余额
    protected $balance_lock;                          //decimal(20,6) unsigned NOT NULL绑定余额
    protected $credit;                                //decimal(20,6) unsigned NOT NULL积分
    protected $create_time;

    //sp
    private $freeze_balance;                        //decimal(20,6) unsigned NOT NULL冻结余额
    private $freeze_balance_lock;                   //decimal(20,6) unsigned NOT NULL冻结绑定余额
    private $freeze_credit;                         //decimal(20,6) unsigned NOT NULL冻结积分
    private $check_password = true;

    //log
    protected $wallet_id;
    protected $type;                  //char(100) NOT NULL操作类型
    protected $description;           //varchar(1024) NULL描述
    protected $data;                  //varchar(4096) NULL其他序列化数据
    protected $operator_uid;          //char(40) NULL操作人UID
    protected $operator_identity_name;          //char(40) NULL操作人姓名
    protected $operator_login_name;          //char(40) NULL操作人登录名
    protected $operator_mobile;          //char(40) NULL操作人手机

    //pay password
    protected $mobile;

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
    public function getPayPassword()
    {
        return $this->pay_password;
    }

    /**
     * @param mixed $pay_password
     */
    public function setPayPassword($pay_password)
    {
        $this->pay_password = $pay_password;
    }

    /**
     * @return mixed
     */
    public function getPayPasswordLevel()
    {
        return $this->pay_password_level;
    }

    /**
     * @param mixed $pay_password_level
     */
    public function setPayPasswordLevel($pay_password_level)
    {
        $this->pay_password_level = $pay_password_level;
    }

    /**
     * @return mixed
     */
    public function getPayPasswordConfirm()
    {
        return $this->pay_password_confirm;
    }

    /**
     * @param mixed $pay_password_confirm
     */
    public function setPayPasswordConfirm($pay_password_confirm)
    {
        $this->pay_password_confirm = $pay_password_confirm;
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

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return mixed
     */
    public function getBalanceLock()
    {
        return $this->balance_lock;
    }

    /**
     * @param mixed $balance_lock
     */
    public function setBalanceLock($balance_lock)
    {
        $this->balance_lock = $balance_lock;
    }

    /**
     * @return mixed
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @param mixed $credit
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getFreezeBalance()
    {
        return $this->freeze_balance;
    }

    /**
     * @param mixed $freeze_balance
     */
    public function setFreezeBalance($freeze_balance)
    {
        $this->freeze_balance = $freeze_balance;
    }

    /**
     * @return mixed
     */
    public function getFreezeBalanceLock()
    {
        return $this->freeze_balance_lock;
    }

    /**
     * @param mixed $freeze_balance_lock
     */
    public function setFreezeBalanceLock($freeze_balance_lock)
    {
        $this->freeze_balance_lock = $freeze_balance_lock;
    }

    /**
     * @return mixed
     */
    public function getFreezeCredit()
    {
        return $this->freeze_credit;
    }

    /**
     * @param mixed $freeze_credit
     */
    public function setFreezeCredit($freeze_credit)
    {
        $this->freeze_credit = $freeze_credit;
    }

    /**
     * @return mixed
     */
    public function getWalletId()
    {
        return $this->wallet_id;
    }

    /**
     * @param mixed $wallet_id
     */
    public function setWalletId($wallet_id)
    {
        $this->wallet_id = $wallet_id;
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
    public function getOperatorUid()
    {
        return $this->operator_uid;
    }

    /**
     * @param mixed $operator_uid
     */
    public function setOperatorUid($operator_uid)
    {
        $this->operator_uid = $operator_uid;
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
     * @return bool
     */
    public function isCheckPassword()
    {
        return $this->check_password;
    }

    /**
     * @param bool $check_password
     */
    public function setCheckPassword(bool $check_password)
    {
        $this->check_password = $check_password;
    }

    /**
     * @return mixed
     */
    public function getOperatorIdentityName()
    {
        return $this->operator_identity_name;
    }

    /**
     * @param mixed $operator_identity_name
     */
    public function setOperatorIdentityName($operator_identity_name): void
    {
        $this->operator_identity_name = $operator_identity_name;
    }

    /**
     * @return mixed
     */
    public function getOperatorLoginName()
    {
        return $this->operator_login_name;
    }

    /**
     * @param mixed $operator_login_name
     */
    public function setOperatorLoginName($operator_login_name): void
    {
        $this->operator_login_name = $operator_login_name;
    }

    /**
     * @return mixed
     */
    public function getOperatorMobile()
    {
        return $this->operator_mobile;
    }

    /**
     * @param mixed $operator_mobile
     */
    public function setOperatorMobile($operator_mobile): void
    {
        $this->operator_mobile = $operator_mobile;
    }

}