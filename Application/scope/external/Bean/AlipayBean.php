<?php
namespace External\Bean;
/**
 * Date: 2018/10/24
 */
class AlipayBean extends AbstractBean
{

    protected $order_no;
    protected $return_url;
    protected $back_url;

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

}