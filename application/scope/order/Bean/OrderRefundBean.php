<?php
namespace Order\Bean;

class OrderRefundBean extends AbstractBean{

    protected $id;                            //int(15) unsigned NOT NULL
    protected $uid;                           //char(40) NOT NULL申请售后单人
    protected $from_order_id;                 //bigint(20) NOT NULL从哪个订单来
    protected $from_order_no;                 //char(30) NOT NULL从哪个订单号来
    protected $no;               //char(30) NOT NULL订单号
    protected $type;             //char(20) NOT NULL订单类型
    protected $name;             //char(50) NULL订单交易名
    protected $desc;             //char(128) NULL订单简述
    protected $status;           //smallint(5) NOT NULL订单状态
    protected $item_id;          //bigint(20) unsigned NOT NULL物件在订单中的itemid
    protected $refund_data;                   //
    protected $total_qty;                     //int(10) unsigned NOT NULL退货退款货物数量
    protected $total_amount;                  //decimal(20,2) NOT NULL退货退款货物价值
    protected $cancel_time;                   //datetime NULL取消时间
    protected $auto_cancel_time;              //datetime NULL自动取消时间
    protected $apply_time;                    //datetime NOT NULL退款申请时间
    protected $apply_remark;                  //varchar(1024) NULL退款申请备注
    protected $replace_or_repair_remark;      //varchar(1024) NULL换货维修备注
    protected $agree_time;                    //datetime NULL退款同意时间
    protected $agree_remark;                  //varchar(1024) NULL退款同意备注
    protected $agree_operator_uid;            //char(40) NULL退款同意操作人uid
    protected $reject_time;                   //datetime NULL退款不同意时间
    protected $reject_remark;                 //varchar(1024) NULL退款不同意备注
    protected $reject_operator_uid;           //char(40) NULL退款不同意操作人uid
    protected $sent_time;                     //datetime NULL发货时间
    protected $sent_express_code;             //char(100) NULL退款货快递代码
    protected $sent_express_no;               //char(50) NULL退款货快递号
    protected $received_time;                 //datetime NULL收货时间
    protected $sent_back_time;                //datetime NULL返货时间
    protected $sent_back_express_code;        //char(100) NULL售后返回快递码（换货/维修）
    protected $sent_back_express_no;          //char(50) NULL售后返回快递单号（换货/维修）
    protected $sent_back_remarks;             //varchar(1024) NULL售后返回备注
    protected $finish_time;                   //datetime NULL退款完成时间

    //search
    protected $item_name;
    protected $real_name;
    protected $mobile;

    //other
    protected $pay_password;

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
    public function getFromOrderId()
    {
        return $this->from_order_id;
    }

    /**
     * @param mixed $from_order_id
     */
    public function setFromOrderId($from_order_id)
    {
        $this->from_order_id = $from_order_id;
    }

    /**
     * @return mixed
     */
    public function getFromOrderNo()
    {
        return $this->from_order_no;
    }

    /**
     * @param mixed $from_order_no
     */
    public function setFromOrderNo($from_order_no)
    {
        $this->from_order_no = $from_order_no;
    }

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
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc): void
    {
        $this->desc = $desc;
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
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id): void
    {
        $this->item_id = $item_id;
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
    public function setTotalQty($total_qty)
    {
        $this->total_qty = $total_qty;
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
    public function setTotalAmount($total_amount)
    {
        $this->total_amount = $total_amount;
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
    public function setCancelTime($cancel_time)
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
    public function setAutoCancelTime($auto_cancel_time)
    {
        $this->auto_cancel_time = $auto_cancel_time;
    }

    /**
     * @return mixed
     */
    public function getApplyTime()
    {
        return $this->apply_time;
    }

    /**
     * @param mixed $apply_time
     */
    public function setApplyTime($apply_time)
    {
        $this->apply_time = $apply_time;
    }

    /**
     * @return mixed
     */
    public function getApplyRemark()
    {
        return $this->apply_remark;
    }

    /**
     * @param mixed $apply_remark
     */
    public function setApplyRemark($apply_remark)
    {
        $this->apply_remark = $apply_remark;
    }

    /**
     * @return mixed
     */
    public function getReplaceOrRepairRemark()
    {
        return $this->replace_or_repair_remark;
    }

    /**
     * @param mixed $replace_or_repair_remark
     */
    public function setReplaceOrRepairRemark($replace_or_repair_remark)
    {
        $this->replace_or_repair_remark = $replace_or_repair_remark;
    }

    /**
     * @return mixed
     */
    public function getAgreeTime()
    {
        return $this->agree_time;
    }

    /**
     * @param mixed $agree_time
     */
    public function setAgreeTime($agree_time)
    {
        $this->agree_time = $agree_time;
    }

    /**
     * @return mixed
     */
    public function getAgreeRemark()
    {
        return $this->agree_remark;
    }

    /**
     * @param mixed $agree_remark
     */
    public function setAgreeRemark($agree_remark)
    {
        $this->agree_remark = $agree_remark;
    }

    /**
     * @return mixed
     */
    public function getAgreeOperatorUid()
    {
        return $this->agree_operator_uid;
    }

    /**
     * @param mixed $agree_operator_uid
     */
    public function setAgreeOperatorUid($agree_operator_uid)
    {
        $this->agree_operator_uid = $agree_operator_uid;
    }

    /**
     * @return mixed
     */
    public function getRejectTime()
    {
        return $this->reject_time;
    }

    /**
     * @param mixed $reject_time
     */
    public function setRejectTime($reject_time)
    {
        $this->reject_time = $reject_time;
    }

    /**
     * @return mixed
     */
    public function getRejectRemark()
    {
        return $this->reject_remark;
    }

    /**
     * @param mixed $reject_remark
     */
    public function setRejectRemark($reject_remark)
    {
        $this->reject_remark = $reject_remark;
    }

    /**
     * @return mixed
     */
    public function getRejectOperatorUid()
    {
        return $this->reject_operator_uid;
    }

    /**
     * @param mixed $reject_operator_uid
     */
    public function setRejectOperatorUid($reject_operator_uid)
    {
        $this->reject_operator_uid = $reject_operator_uid;
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
    public function setSentTime($sent_time)
    {
        $this->sent_time = $sent_time;
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
    public function setSentExpressCode($sent_express_code)
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
    public function setSentExpressNo($sent_express_no)
    {
        $this->sent_express_no = $sent_express_no;
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
    public function setReceivedTime($received_time)
    {
        $this->received_time = $received_time;
    }

    /**
     * @return mixed
     */
    public function getSentBackTime()
    {
        return $this->sent_back_time;
    }

    /**
     * @param mixed $sent_back_time
     */
    public function setSentBackTime($sent_back_time)
    {
        $this->sent_back_time = $sent_back_time;
    }

    /**
     * @return mixed
     */
    public function getSentBackExpressCode()
    {
        return $this->sent_back_express_code;
    }

    /**
     * @param mixed $sent_back_express_code
     */
    public function setSentBackExpressCode($sent_back_express_code)
    {
        $this->sent_back_express_code = $sent_back_express_code;
    }

    /**
     * @return mixed
     */
    public function getSentBackExpressNo()
    {
        return $this->sent_back_express_no;
    }

    /**
     * @param mixed $sent_back_express_no
     */
    public function setSentBackExpressNo($sent_back_express_no)
    {
        $this->sent_back_express_no = $sent_back_express_no;
    }

    /**
     * @return mixed
     */
    public function getSentBackRemarks()
    {
        return $this->sent_back_remarks;
    }

    /**
     * @param mixed $sent_back_remarks
     */
    public function setSentBackRemarks($sent_back_remarks)
    {
        $this->sent_back_remarks = $sent_back_remarks;
    }

    /**
     * @return mixed
     */
    public function getFinishTime()
    {
        return $this->finish_time;
    }

    /**
     * @param mixed $finish_time
     */
    public function setFinishTime($finish_time)
    {
        $this->finish_time = $finish_time;
    }

    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * @param mixed $item_name
     */
    public function setItemName($item_name)
    {
        $this->item_name = $item_name;
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
    public function getRefundData()
    {
        return $this->refund_data;
    }

    /**
     * @param mixed $refund_data
     */
    public function setRefundData($refund_data)
    {
        $this->refund_data = $refund_data;
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

}
