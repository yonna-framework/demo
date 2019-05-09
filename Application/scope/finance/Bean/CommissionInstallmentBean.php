<?php

namespace Finance\Bean;
use Common\Bean\AbstractBean;

class CommissionInstallmentBean extends AbstractBean{

    protected $id;                                    //int(15) unsigned NOT NULL
    protected $uid;                                   //char(40) NOT NULL uid
    protected $type;                                  //char(50) NOT NULL类型
    protected $description;                           //char(200) NULL描述
    protected $balance;                               //decimal(20,6) unsigned NOT NULL每期分 余额
    protected $balance_lock;                          //decimal(20,6) unsigned NOT NULL每期分 绑定余额
    protected $credit;                                //decimal(20,6) unsigned NOT NULL每期分 积分
    protected $base_balance;                          //decimal(20,6) unsigned NOT NULL分佣基础 余额
    protected $base_balance_lock;                     //decimal(20,6) unsigned NOT NULL分佣基础 绑定余额
    protected $base_credit;                           //decimal(20,6) unsigned NOT NULL分佣基础 积分
    protected $base_percent_balance;                  //decimal(8,5) unsigned NOT NULL计算比例 金额
    protected $base_percent_balance_lock;             //decimal(8,5) unsigned NOT NULL计算比例 绑定余额
    protected $base_percent_credit;                   //decimal(8,5) unsigned NOT NULL计算比例 积分
    protected $start_number_of_installments;          //int(4) unsigned NOT NULL开始期数
    protected $current_number_of_installments;        //int(3) unsigned NOT NULL当前期数
    protected $number_of_installments;                //int(3) unsigned NOT NULL分期总期数
    protected $is_enable;                             //tinyint(2) NOT NULL是否有效
    protected $is_over;                               //tinyint(2) NOT NULL是否已结束
    protected $from_uid;                              //char(40) NULL从何人来
    protected $data;                                  //text NULL记录数据
    protected $last_installment_time;                 //datetime NULL最后一次分佣时间
    protected $estimated_time;                        //datetime NOT NULL预计分佣时间
    protected $create_time;

    //ADD
    protected $role_id;
    protected $inviter_uid;

    protected $mobile;
    protected $from_mobile;
    protected $order_no;

    //new
    protected $installments_unit;
    protected $installments_unit_length;

    /**
     * @return mixed
     */
    public function getInstallmentsUnit()
    {
        return $this->installments_unit;
    }

    /**
     * @param mixed $installments_unit
     */
    public function setInstallmentsUnit($installments_unit)
    {
        $this->installments_unit = $installments_unit;
    }

    /**
     * @return mixed
     */
    public function getInstallmentsUnitLength()
    {
        return $this->installments_unit_length;
    }

    /**
     * @param mixed $installments_unit_length
     */
    public function setInstallmentsUnitLength($installments_unit_length)
    {
        $this->installments_unit_length = $installments_unit_length;
    }

    /**
     * @return mixed
     */
    public function getOrderNo() {
        return $this->order_no;
    }

    /**
     * @param mixed $order_no
     */
    public function setOrderNo($order_no) {
        $this->order_no = $order_no;
    }

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
    public function getBaseBalanceLock()
    {
        return $this->base_balance_lock;
    }

    /**
     * @param mixed $base_balance_lock
     */
    public function setBaseBalanceLock($base_balance_lock)
    {
        $this->base_balance_lock = $base_balance_lock;
    }

    /**
     * @return mixed
     */
    public function getBaseCredit()
    {
        return $this->base_credit;
    }

    /**
     * @param mixed $base_credit
     */
    public function setBaseCredit($base_credit)
    {
        $this->base_credit = $base_credit;
    }

    /**
     * @return mixed
     */
    public function getBasePercentBalanceLock()
    {
        return $this->base_percent_balance_lock;
    }

    /**
     * @param mixed $base_percent_balance_lock
     */
    public function setBasePercentBalanceLock($base_percent_balance_lock)
    {
        $this->base_percent_balance_lock = $base_percent_balance_lock;
    }

    /**
     * @return mixed
     */
    public function getBasePercentCredit()
    {
        return $this->base_percent_credit;
    }

    /**
     * @param mixed $base_percent_credit
     */
    public function setBasePercentCredit($base_percent_credit)
    {
        $this->base_percent_credit = $base_percent_credit;
    }

    /**
     * @return mixed
     */
    public function getBaseBalance()
    {
        return $this->base_balance;
    }

    /**
     * @param mixed $base_balance
     */
    public function setBaseBalance($base_balance)
    {
        $this->base_balance = $base_balance;
    }

    /**
     * @return mixed
     */
    public function getBasePercentBalance()
    {
        return $this->base_percent_balance;
    }

    /**
     * @param mixed $base_percent_balance
     */
    public function setBasePercentBalance($base_percent_balance)
    {
        $this->base_percent_balance = $base_percent_balance;
    }

    /**
     * @return mixed
     */
    public function getStartNumberOfInstallments()
    {
        return $this->start_number_of_installments;
    }

    /**
     * @param mixed $start_number_of_installments
     */
    public function setStartNumberOfInstallments($start_number_of_installments)
    {
        $this->start_number_of_installments = $start_number_of_installments;
    }

    /**
     * @return mixed
     */
    public function getNumberOfInstallments()
    {
        return $this->number_of_installments;
    }

    /**
     * @param mixed $number_of_installments
     */
    public function setNumberOfInstallments($number_of_installments)
    {
        $this->number_of_installments = $number_of_installments;
    }

    /**
     * @return mixed
     */
    public function getCurrentNumberOfInstallments()
    {
        return $this->current_number_of_installments;
    }

    /**
     * @param mixed $current_number_of_installments
     */
    public function setCurrentNumberOfInstallments($current_number_of_installments)
    {
        $this->current_number_of_installments = $current_number_of_installments;
    }

    /**
     * @return mixed
     */
    public function getIsEnable()
    {
        return $this->is_enable;
    }

    /**
     * @param mixed $is_enable
     */
    public function setIsEnable($is_enable)
    {
        $this->is_enable = $is_enable;
    }

    /**
     * @return mixed
     */
    public function getIsOver()
    {
        return $this->is_over;
    }

    /**
     * @param mixed $is_over
     */
    public function setIsOver($is_over)
    {
        $this->is_over = $is_over;
    }

    /**
     * @return mixed
     */
    public function getFromUid()
    {
        return $this->from_uid;
    }

    /**
     * @param mixed $from_uid
     */
    public function setFromUid($from_uid)
    {
        $this->from_uid = $from_uid;
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
    public function getLastInstallmentTime()
    {
        return $this->last_installment_time;
    }

    /**
     * @param mixed $last_installment_time
     */
    public function setLastInstallmentTime($last_installment_time)
    {
        $this->last_installment_time = $last_installment_time;
    }

    /**
     * @return mixed
     */
    public function getEstimatedTime()
    {
        return $this->estimated_time;
    }

    /**
     * @param mixed $estimated_time
     */
    public function setEstimatedTime($estimated_time)
    {
        $this->estimated_time = $estimated_time;
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
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    /**
     * @return mixed
     */
    public function getInviterUid()
    {
        return $this->inviter_uid;
    }

    /**
     * @param mixed $inviter_uid
     */
    public function setInviterUid($inviter_uid)
    {
        $this->inviter_uid = $inviter_uid;
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
    public function getFromMobile()
    {
        return $this->from_mobile;
    }

    /**
     * @param mixed $from_mobile
     */
    public function setFromMobile($from_mobile)
    {
        $this->from_mobile = $from_mobile;
    }

}