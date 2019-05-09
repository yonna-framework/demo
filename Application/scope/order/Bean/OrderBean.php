<?php
namespace Order\Bean;

class OrderBean extends AbstractBean {

    protected $id; //bigserial NOT NULL,
    protected $uid; // bigint NOT NULL,
    protected $no; // text NOT NULL,
    protected $type; // text NOT NULL,
    protected $name; // text,
    protected $description; // text,
    protected $status; // smallint NOT NULL DEFAULT -1,
    protected $trade_place; // text,
    protected $trade_terminal; // text,
    protected $total_amount; // numeric(20,2) NOT NULL,
    protected $total_freight; // numeric(20,2) NOT NULL,
    protected $total_favorable; // numeric(20,2) NOT NULL,
    protected $total_weight; // numeric(20,2) NOT NULL,
    protected $total_qty; // bigint NOT NULL,
    protected $pay_amount; // numeric(20,2) NOT NULL,
    protected $pay_status; // smallint NOT NULL DEFAULT -1,
    protected $pay_type; // text,
    protected $shop_id;               // NULL店铺ID
    protected $buyer_remarks; // text,
    protected $seller_remarks; // text,
    protected $pay_return_data; // text,
    protected $shipping_region; // text,
    protected $shipping_address; // text,
    protected $contact_user; // text,
    protected $contact_mobile; // text,
    protected $create_time; // timestamp without time zone NOT NULL,
    protected $cancel_time; // timestamp without time zone,
    protected $auto_cancel_time; // timestamp without time zone,
    protected $pay_time; // timestamp without time zone,
    protected $sent_time; //timestamp without time zone,
    protected $sent_operator_uid; // bigint,
    protected $sent_express_code; // text,
    protected $sent_express_no; // text,
    protected $sent_remarks; // text,
    protected $received_time; // timestamp without time zone,
    protected $evaluate_time; // timestamp without time zone,

    //search
    protected $real_name;
    protected $mobile;

    //build
    protected $order_data;        //text NULL订单数据
    protected $confirm_info;
    protected $pay_password;

    //evaluation
    protected $evaluation_info;

    /**
     * @return mixed
     */
    public function getNo()
    {
        return $this->no;
    }

    /**
     * @param mixed $no
     */
    public function setNo($no): void
    {
        $this->no = $no;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
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
    public function setStatus($status): void
    {
        $this->status = $status;
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
    public function setId($id): void
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
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }


    /**
     * @return mixed
     */
    public function getTradePlace()
    {
        return $this->trade_place;
    }

    /**
     * @param mixed $trade_place
     */
    public function setTradePlace($trade_place): void
    {
        $this->trade_place = $trade_place;
    }

    /**
     * @return mixed
     */
    public function getTradeTerminal()
    {
        return $this->trade_terminal;
    }

    /**
     * @param mixed $trade_terminal
     */
    public function setTradeTerminal($trade_terminal): void
    {
        $this->trade_terminal = $trade_terminal;
    }

    /**
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    /**
     * @param mixed $total_amount
     */
    public function setTotalAmount($total_amount): void
    {
        $this->total_amount = $total_amount;
    }

    /**
     * @return mixed
     */
    public function getTotalFreight()
    {
        return $this->total_freight;
    }

    /**
     * @param mixed $total_freight
     */
    public function setTotalFreight($total_freight): void
    {
        $this->total_freight = $total_freight;
    }

    /**
     * @return mixed
     */
    public function getTotalFavorable()
    {
        return $this->total_favorable;
    }

    /**
     * @param mixed $total_favorable
     */
    public function setTotalFavorable($total_favorable): void
    {
        $this->total_favorable = $total_favorable;
    }

    /**
     * @return mixed
     */
    public function getTotalWeight()
    {
        return $this->total_weight;
    }

    /**
     * @param mixed $total_weight
     */
    public function setTotalWeight($total_weight): void
    {
        $this->total_weight = $total_weight;
    }

    /**
     * @return mixed
     */
    public function getTotalQty()
    {
        return $this->total_qty;
    }

    /**
     * @param mixed $total_qty
     */
    public function setTotalQty($total_qty): void
    {
        $this->total_qty = $total_qty;
    }

    /**
     * @return mixed
     */
    public function getPayAmount()
    {
        return $this->pay_amount;
    }

    /**
     * @param mixed $pay_amount
     */
    public function setPayAmount($pay_amount): void
    {
        $this->pay_amount = $pay_amount;
    }

    /**
     * @return mixed
     */
    public function getPayStatus()
    {
        return $this->pay_status;
    }

    /**
     * @param mixed $pay_status
     */
    public function setPayStatus($pay_status): void
    {
        $this->pay_status = $pay_status;
    }

    /**
     * @return mixed
     */
    public function getPayType()
    {
        return $this->pay_type;
    }

    /**
     * @param mixed $pay_type
     */
    public function setPayType($pay_type): void
    {
        $this->pay_type = $pay_type;
    }

    /**
     * @return mixed
     */
    public function getShopId()
    {
        return $this->shop_id;
    }

    /**
     * @param mixed $shop_id
     */
    public function setShopId($shop_id): void
    {
        $this->shop_id = $shop_id;
    }

    /**
     * @return mixed
     */
    public function getBuyerRemarks()
    {
        return $this->buyer_remarks;
    }

    /**
     * @param mixed $buyer_remarks
     */
    public function setBuyerRemarks($buyer_remarks): void
    {
        $this->buyer_remarks = $buyer_remarks;
    }

    /**
     * @return mixed
     */
    public function getSellerRemarks()
    {
        return $this->seller_remarks;
    }

    /**
     * @param mixed $seller_remarks
     */
    public function setSellerRemarks($seller_remarks): void
    {
        $this->seller_remarks = $seller_remarks;
    }

    /**
     * @return mixed
     */
    public function getPayReturnData()
    {
        return $this->pay_return_data;
    }

    /**
     * @param mixed $pay_return_data
     */
    public function setPayReturnData($pay_return_data): void
    {
        $this->pay_return_data = $pay_return_data;
    }

    /**
     * @return mixed
     */
    public function getShippingRegion()
    {
        return $this->shipping_region;
    }

    /**
     * @param mixed $shipping_region
     */
    public function setShippingRegion($shipping_region): void
    {
        $this->shipping_region = $shipping_region;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }

    /**
     * @param mixed $shipping_address
     */
    public function setShippingAddress($shipping_address): void
    {
        $this->shipping_address = $shipping_address;
    }

    /**
     * @return mixed
     */
    public function getContactUser()
    {
        return $this->contact_user;
    }

    /**
     * @param mixed $contact_user
     */
    public function setContactUser($contact_user): void
    {
        $this->contact_user = $contact_user;
    }

    /**
     * @return mixed
     */
    public function getContactMobile()
    {
        return $this->contact_mobile;
    }

    /**
     * @param mixed $contact_mobile
     */
    public function setContactMobile($contact_mobile): void
    {
        $this->contact_mobile = $contact_mobile;
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
    public function setCreateTime($create_time): void
    {
        $this->create_time = $create_time;
    }

    /**
     * @return mixed
     */
    public function getCancelTime()
    {
        return $this->cancel_time;
    }

    /**
     * @param mixed $cancel_time
     */
    public function setCancelTime($cancel_time): void
    {
        $this->cancel_time = $cancel_time;
    }

    /**
     * @return mixed
     */
    public function getAutoCancelTime()
    {
        return $this->auto_cancel_time;
    }

    /**
     * @param mixed $auto_cancel_time
     */
    public function setAutoCancelTime($auto_cancel_time): void
    {
        $this->auto_cancel_time = $auto_cancel_time;
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

    /**
     * @return mixed
     */
    public function getSentTime()
    {
        return $this->sent_time;
    }

    /**
     * @param mixed $sent_time
     */
    public function setSentTime($sent_time): void
    {
        $this->sent_time = $sent_time;
    }

    /**
     * @return mixed
     */
    public function getSentOperatorUid()
    {
        return $this->sent_operator_uid;
    }

    /**
     * @param mixed $sent_operator_uid
     */
    public function setSentOperatorUid($sent_operator_uid): void
    {
        $this->sent_operator_uid = $sent_operator_uid;
    }

    /**
     * @return mixed
     */
    public function getSentExpressCode()
    {
        return $this->sent_express_code;
    }

    /**
     * @param mixed $sent_express_code
     */
    public function setSentExpressCode($sent_express_code): void
    {
        $this->sent_express_code = $sent_express_code;
    }

    /**
     * @return mixed
     */
    public function getSentExpressNo()
    {
        return $this->sent_express_no;
    }

    /**
     * @param mixed $sent_express_no
     */
    public function setSentExpressNo($sent_express_no): void
    {
        $this->sent_express_no = $sent_express_no;
    }

    /**
     * @return mixed
     */
    public function getSentRemarks()
    {
        return $this->sent_remarks;
    }

    /**
     * @param mixed $sent_remarks
     */
    public function setSentRemarks($sent_remarks): void
    {
        $this->sent_remarks = $sent_remarks;
    }

    /**
     * @return mixed
     */
    public function getReceivedTime()
    {
        return $this->received_time;
    }

    /**
     * @param mixed $received_time
     */
    public function setReceivedTime($received_time): void
    {
        $this->received_time = $received_time;
    }

    /**
     * @return mixed
     */
    public function getEvaluateTime()
    {
        return $this->evaluate_time;
    }

    /**
     * @param mixed $evaluate_time
     */
    public function setEvaluateTime($evaluate_time): void
    {
        $this->evaluate_time = $evaluate_time;
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
    public function setRealName($real_name): void
    {
        $this->real_name = $real_name;
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
    public function setMobile($mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getOrderData()
    {
        return $this->order_data;
    }

    /**
     * @param mixed $order_data
     */
    public function setOrderData($order_data): void
    {
        $this->order_data = $order_data;
    }

    /**
     * @return mixed
     */
    public function getConfirmInfo()
    {
        return $this->confirm_info;
    }

    /**
     * @param mixed $confirm_info
     */
    public function setConfirmInfo($confirm_info): void
    {
        $this->confirm_info = $confirm_info;
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
    public function setPayPassword($pay_password): void
    {
        $this->pay_password = $pay_password;
    }

    /**
     * @return mixed
     */
    public function getEvaluationInfo()
    {
        return $this->evaluation_info;
    }

    /**
     * @param mixed $evaluation_info
     */
    public function setEvaluationInfo($evaluation_info): void
    {
        $this->evaluation_info = $evaluation_info;
    }





}
