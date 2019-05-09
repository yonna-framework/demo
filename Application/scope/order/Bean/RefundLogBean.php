<?php
namespace Order\Bean;

class RefundLogBean extends AbstractBean {

    protected $order_id; // bigint NOT NULL,
    protected $operator_uid; // bigint,
    protected $operator; // text NOT NULL,
    protected $data; // jsonb,
    protected $log_time;

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id): void
    {
        $this->order_id = $order_id;
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
    public function setOperatorUid($operator_uid): void
    {
        $this->operator_uid = $operator_uid;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     */
    public function setOperator($operator): void
    {
        $this->operator = $operator;
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
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getLogTime()
    {
        return $this->log_time;
    }

    /**
     * @param mixed $log_time
     */
    public function setLogTime($log_time): void
    {
        $this->log_time = $log_time;
    } // timestamp without time zone NOT NULL

}