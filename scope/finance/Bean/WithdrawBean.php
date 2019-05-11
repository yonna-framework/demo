<?php
namespace Finance\Bean;
use Common\Bean\AbstractBean;

/**
 * Created by PhpStorm.
 * Date: 2018/01/15
 */

class WithdrawBean extends AbstractBean{

    //req
    protected $uid;                   //uid
    protected $pre_min_limit;         //decimal(20,3) unsigned NOT NULL提现下限,低于不允许提现，默认0.01
    protected $pre_max_limit;         //decimal(20,3) unsigned NOT NULL单次提现上限，默认1000
    protected $day_max_limit;         //decimal(20,3) unsigned NOT NULL单日提现上限，默认10000
    protected $cooling_period;        //int(3) NOT NULL提现冷却天数，默认为0
    protected $status;                //tinyint(2) NOT NULL是否允许提现 1允许 -1不允许
    protected $create_time;           //datetime NOT NULL创建时间
    protected $last_apply_time;       //datetime NULL最后一次申请提现日期

    //member-info
    protected $real_name;             //真实姓名
    protected $identity_auth_status;  //实名认证状态

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
    public function getPreMinLimit()
    {
        return $this->pre_min_limit;
    }

    /**
     * @param mixed $pre_min_limit
     */
    public function setPreMinLimit($pre_min_limit)
    {
        $this->pre_min_limit = $pre_min_limit;
    }

    /**
     * @return mixed
     */
    public function getPreMaxLimit()
    {
        return $this->pre_max_limit;
    }

    /**
     * @param mixed $pre_max_limit
     */
    public function setPreMaxLimit($pre_max_limit)
    {
        $this->pre_max_limit = $pre_max_limit;
    }

    /**
     * @return mixed
     */
    public function getDayMaxLimit()
    {
        return $this->day_max_limit;
    }

    /**
     * @param mixed $day_max_limit
     */
    public function setDayMaxLimit($day_max_limit)
    {
        $this->day_max_limit = $day_max_limit;
    }

    /**
     * @return mixed
     */
    public function getCoolingPeriod()
    {
        return $this->cooling_period;
    }

    /**
     * @param mixed $cooling_period
     */
    public function setCoolingPeriod($cooling_period)
    {
        $this->cooling_period = (int)$cooling_period;
    }

    /**
     * @return mixed
     */
    public function getLastApplyTime()
    {
        return $this->last_apply_time;
    }

    /**
     * @param mixed $last_apply_time
     */
    public function setLastApplyTime($last_apply_time)
    {
        $this->last_apply_time = $last_apply_time;
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

}