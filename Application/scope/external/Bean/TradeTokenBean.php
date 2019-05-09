<?php
namespace External\Bean;
/**
 * Date: 2018/10/30
 */
class TradeTokenBean extends \Common\Bean\AbstractBean
{

    protected $create_time; //创建时间';
    protected $out_trade_no; //对外交易号';
    protected $order_no; //对内订单号';
    protected $type; //类型';
    protected $amount; //金额';
    protected $config; //对应的配置';
    protected $params; //请求数据';
    protected $callback; //回调数据';
    protected $is_pay; //是否已支付';
    protected $pay_account; //支付账号';
    protected $pay_time;

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
    public function setCreateTime($create_time): void
    {
        $this->create_time = $create_time;
    }

    /**
     * @return mixed
     */
    public function getOutTradeNo()
    {
        return $this->out_trade_no;
    }

    /**
     * @param mixed $out_trade_no
     */
    public function setOutTradeNo($out_trade_no): void
    {
        $this->out_trade_no = $out_trade_no;
    }

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
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
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config): void
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params): void
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param mixed $callback
     */
    public function setCallback($callback): void
    {
        $this->callback = $callback;
    }

    /**
     * @return mixed
     */
    public function getIsPay()
    {
        return $this->is_pay;
    }

    /**
     * @param mixed $is_pay
     */
    public function setIsPay($is_pay): void
    {
        $this->is_pay = $is_pay;
    }

    /**
     * @return mixed
     */
    public function getPayAccount()
    {
        return $this->pay_account;
    }

    /**
     * @param mixed $pay_account
     */
    public function setPayAccount($pay_account): void
    {
        $this->pay_account = $pay_account;
    }

    /**
     * @return mixed
     */
    public function getPayTime()
    {
        return $this->pay_time;
    }

    /**
     * @param mixed $pay_time
     */
    public function setPayTime($pay_time): void
    {
        $this->pay_time = $pay_time;
    }

}