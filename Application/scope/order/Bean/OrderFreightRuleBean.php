<?php

namespace Order\Bean;


class OrderFreightRuleBean extends AbstractBean{

    protected $id;                    //int(10) unsigned NOT NULL
    protected $status;                //tinyint(1) NOT NULL状态
    protected $pri;                   //int(5) unsigned NOT NULL优先级
    protected $seller_uid;            //char(40) NULL指定的卖家uid
    protected $region;                //char(1) NULL指定的地区
    protected $is_free_shipping;      //tinyint(1) NOT NULL是否包邮
    protected $rule_type;             //char(20) NOT NULL邮费规则类型
    protected $first_kilo;            //decimal(20,3) unsigned NULL首重重量
    protected $fee_first_kilo;        //decimal(20,3) unsigned NULL首重费用，优先级高的覆盖低的
    protected $fee_per_kilo;          //decimal(20,3) unsigned NULL每kg多少费用，如果有首重，从首重后1kg开始算，优先级高的覆盖低的
    protected $fee_first_qty;         //decimal(20,3) NULL首件费用
    protected $fee_per_qty;           //decimal(20,3) NULL续件费用
    protected $volume_var;            //int(10) unsigned NULL邮费计算 - 体积参数（长*宽*高）/var = 重量
    protected $free_shipping_kilo;    //decimal(20,3) NULL包邮重量(不超过的话)
    protected $free_shipping_amount;  //decimal(20,3) NULL包邮金额(超过的话)
    protected $free_shipping_qty;     //int(10) NULL包邮购买数量(超过的话)
    protected $create_time;           //datetime NOT NULL

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
    public function getPri()
    {
        return $this->pri;
    }

    /**
     * @param mixed $pri
     */
    public function setPri($pri)
    {
        $this->pri = $pri;
    }

    /**
     * @return mixed
     */
    public function getSellerUid()
    {
        return $this->seller_uid;
    }

    /**
     * @param mixed $seller_uid
     */
    public function setSellerUid($seller_uid)
    {
        $this->seller_uid = $seller_uid;
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
    public function getIsFreeShipping()
    {
        return $this->is_free_shipping;
    }

    /**
     * @param mixed $is_free_shipping
     */
    public function setIsFreeShipping($is_free_shipping)
    {
        $this->is_free_shipping = $is_free_shipping;
    }

    /**
     * @return mixed
     */
    public function getRuleType()
    {
        return $this->rule_type;
    }

    /**
     * @param mixed $rule_type
     */
    public function setRuleType($rule_type)
    {
        $this->rule_type = $rule_type;
    }

    /**
     * @return mixed
     */
    public function getFirstKilo()
    {
        return $this->first_kilo;
    }

    /**
     * @param mixed $first_kilo
     */
    public function setFirstKilo($first_kilo)
    {
        $this->first_kilo = $first_kilo;
    }

    /**
     * @return mixed
     */
    public function getFeeFirstKilo()
    {
        return $this->fee_first_kilo;
    }

    /**
     * @param mixed $fee_first_kilo
     */
    public function setFeeFirstKilo($fee_first_kilo)
    {
        $this->fee_first_kilo = $fee_first_kilo;
    }

    /**
     * @return mixed
     */
    public function getFeePerKilo()
    {
        return $this->fee_per_kilo;
    }

    /**
     * @param mixed $fee_per_kilo
     */
    public function setFeePerKilo($fee_per_kilo)
    {
        $this->fee_per_kilo = $fee_per_kilo;
    }

    /**
     * @return mixed
     */
    public function getFeeFirstQty()
    {
        return $this->fee_first_qty;
    }

    /**
     * @param mixed $fee_first_qty
     */
    public function setFeeFirstQty($fee_first_qty)
    {
        $this->fee_first_qty = $fee_first_qty;
    }

    /**
     * @return mixed
     */
    public function getFeePerQty()
    {
        return $this->fee_per_qty;
    }

    /**
     * @param mixed $fee_per_qty
     */
    public function setFeePerQty($fee_per_qty)
    {
        $this->fee_per_qty = $fee_per_qty;
    }

    /**
     * @return mixed
     */
    public function getVolumeVar()
    {
        return $this->volume_var;
    }

    /**
     * @param mixed $volume_var
     */
    public function setVolumeVar($volume_var)
    {
        $this->volume_var = $volume_var;
    }

    /**
     * @return mixed
     */
    public function getFreeShippingKilo()
    {
        return $this->free_shipping_kilo;
    }

    /**
     * @param mixed $free_shipping_kilo
     */
    public function setFreeShippingKilo($free_shipping_kilo)
    {
        $this->free_shipping_kilo = $free_shipping_kilo;
    }

    /**
     * @return mixed
     */
    public function getFreeShippingAmount()
    {
        return $this->free_shipping_amount;
    }

    /**
     * @param mixed $free_shipping_amount
     */
    public function setFreeShippingAmount($free_shipping_amount)
    {
        $this->free_shipping_amount = $free_shipping_amount;
    }

    /**
     * @return mixed
     */
    public function getFreeShippingQty()
    {
        return $this->free_shipping_qty;
    }

    /**
     * @param mixed $free_shipping_qty
     */
    public function setFreeShippingQty($free_shipping_qty)
    {
        $this->free_shipping_qty = $free_shipping_qty;
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

}