<?php
namespace External\Bean;
/**
 * Date: 2018/10/29
 */
class WxpayBean extends AbstractBean
{

    protected $order_no;
    protected $return_url;
    protected $back_url;
    protected $open_id;
    protected $code;
    protected $uid;
    protected $amount;
    protected $description;

    protected $callbackData;

    /**
     * @return mixed
     */
    public function getOrderNo()
    {
        return $this->order_no;
    }

    /**
     * @param mixed $order_no
     */
    public function setOrderNo($order_no): void
    {
        $this->order_no = $order_no;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->return_url;
    }

    /**
     * @param mixed $return_url
     */
    public function setReturnUrl($return_url): void
    {
        $this->return_url = $return_url;
    }

    /**
     * @return mixed
     */
    public function getBackUrl()
    {
        return $this->back_url;
    }

    /**
     * @param mixed $back_url
     */
    public function setBackUrl($back_url): void
    {
        $this->back_url = $back_url;
    }

    /**
     * @return mixed
     */
    public function getCallbackData()
    {
        return $this->callbackData;
    }

    /**
     * @param mixed $callbackData
     */
    public function setCallbackData($callbackData): void
    {
        $this->callbackData = $callbackData;
    }

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
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
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
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
    public function setDescription($description): void
    {
        $this->description = $description;
    }

}