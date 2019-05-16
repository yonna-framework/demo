<?php
namespace Order\Bean;

class OrderItemsBean extends AbstractBean
{
    protected $id;                      // bigserial NOT NULL,
    protected $order_id;                // bigint NOT NULL,
    protected $seller_uid;                // bigint NOT NULL,
    protected $seller_name;                // text NOT NULL,
    protected $item_amount;                // numeric(20,2) NOT NULL CHECK (item_amount>=0),
    protected $item_amount_origin;                // numeric(20,2) CHECK (item_amount_origin>=0),
    protected $item_amount_before_favour;         // numeric(20,2) CHECK (item_amount_before_favour>=0),
    protected $item_weight;                // numeric(20,2) NOT NULL CHECK (item_weight>=0),
    protected $item_qty;                // bigint NOT NULL CHECK (item_total_amount>=1),
    protected $item_name;                // text NOT NULL,
    protected $item_total_amount;                // numeric(20,2) NOT NULL CHECK (item_total_amount>=0),
    protected $item_total_weight;                // numeric(20,2) NOT NULL CHECK (item_total_weight>=0),
    protected $item_data;                // text,
    protected $goods_id;                // bigint,
    protected $base_goods_id;                // bigint,
    protected $is_evaluation;                // "default".is_sure NOT NULL DEFAULT '-1',
    protected $refund_qty;

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
    public function getSellerUid()
    {
        return $this->seller_uid;
    }

    /**
     * @param mixed $seller_uid
     */
    public function setSellerUid($seller_uid): void
    {
        $this->seller_uid = $seller_uid;
    }

    /**
     * @return mixed
     */
    public function getSellerName()
    {
        return $this->seller_name;
    }

    /**
     * @param mixed $seller_name
     */
    public function setSellerName($seller_name): void
    {
        $this->seller_name = $seller_name;
    }

    /**
     * @return mixed
     */
    public function getItemAmount()
    {
        return $this->item_amount;
    }

    /**
     * @param mixed $item_amount
     */
    public function setItemAmount($item_amount): void
    {
        $this->item_amount = $item_amount;
    }

    /**
     * @return mixed
     */
    public function getItemAmountOrigin()
    {
        return $this->item_amount_origin;
    }

    /**
     * @param mixed $item_amount_origin
     */
    public function setItemAmountOrigin($item_amount_origin): void
    {
        $this->item_amount_origin = $item_amount_origin;
    }

    /**
     * @return mixed
     */
    public function getItemAmountBeforeFavour()
    {
        return $this->item_amount_before_favour;
    }

    /**
     * @param mixed $item_amount_before_favour
     */
    public function setItemAmountBeforeFavour($item_amount_before_favour): void
    {
        $this->item_amount_before_favour = $item_amount_before_favour;
    }

    /**
     * @return mixed
     */
    public function getItemWeight()
    {
        return $this->item_weight;
    }

    /**
     * @param mixed $item_weight
     */
    public function setItemWeight($item_weight): void
    {
        $this->item_weight = $item_weight;
    }

    /**
     * @return mixed
     */
    public function getItemQty()
    {
        return $this->item_qty;
    }

    /**
     * @param mixed $item_qty
     */
    public function setItemQty($item_qty): void
    {
        $this->item_qty = $item_qty;
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
    public function setItemName($item_name): void
    {
        $this->item_name = $item_name;
    }

    /**
     * @return mixed
     */
    public function getItemTotalAmount()
    {
        return $this->item_total_amount;
    }

    /**
     * @param mixed $item_total_amount
     */
    public function setItemTotalAmount($item_total_amount): void
    {
        $this->item_total_amount = $item_total_amount;
    }

    /**
     * @return mixed
     */
    public function getItemTotalWeight()
    {
        return $this->item_total_weight;
    }

    /**
     * @param mixed $item_total_weight
     */
    public function setItemTotalWeight($item_total_weight): void
    {
        $this->item_total_weight = $item_total_weight;
    }

    /**
     * @return mixed
     */
    public function getItemData()
    {
        return $this->item_data;
    }

    /**
     * @param mixed $item_data
     */
    public function setItemData($item_data): void
    {
        $this->item_data = $item_data;
    }

    /**
     * @return mixed
     */
    public function getGoodsId()
    {
        return $this->goods_id;
    }

    /**
     * @param mixed $goods_id
     */
    public function setGoodsId($goods_id): void
    {
        $this->goods_id = $goods_id;
    }

    /**
     * @return mixed
     */
    public function getBaseGoodsId()
    {
        return $this->base_goods_id;
    }

    /**
     * @param mixed $base_goods_id
     */
    public function setBaseGoodsId($base_goods_id): void
    {
        $this->base_goods_id = $base_goods_id;
    }

    /**
     * @return mixed
     */
    public function getisEvaluation()
    {
        return $this->is_evaluation;
    }

    /**
     * @param mixed $is_evaluation
     */
    public function setIsEvaluation($is_evaluation): void
    {
        $this->is_evaluation = $is_evaluation;
    }

    /**
     * @return mixed
     */
    public function getRefundQty()
    {
        return $this->refund_qty;
    }

    /**
     * @param mixed $refund_qty
     */
    public function setRefundQty($refund_qty): void
    {
        $this->refund_qty = $refund_qty;
    }                // bigint NOT NULL DEFAULT 0 CHECK (refund_qty>=0),

}