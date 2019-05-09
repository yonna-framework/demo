<?php
namespace Finance\Bean;
/**
 * Created by PhpStorm.
 * Date: 2018/01/15
 */
use Common\Bean\AbstractBean;

class WithdrawLogBean extends AbstractBean {

    protected $id;
    protected $apply_id;          //申请ID
    protected $operator_id;       //操作人ID
    protected $apply_amount;      //申请金额
    protected $type;              //操作类型
    protected $description;       //描述
    protected $wallet_id;         //对应的钱包ID
    protected $data;              //其他数据（后台自动序列化处理数据）
    protected $create_time;

    protected $uid;               //用户ID

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
    public function getApplyId()
    {
        return $this->apply_id;
    }

    /**
     * @param mixed $apply_id
     */
    public function setApplyId($apply_id)
    {
        $this->apply_id = $apply_id;
    }

    /**
     * @return mixed
     */
    public function getOperatorId()
    {
        return $this->operator_id;
    }

    /**
     * @param mixed $operator_id
     */
    public function setOperatorId($operator_id)
    {
        $this->operator_id = $operator_id;
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
        $this->apply_amount = round($apply_amount,2);
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

}