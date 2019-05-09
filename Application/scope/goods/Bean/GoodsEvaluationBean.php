<?php

namespace Goods\Bean;

/**
 * Created by PhpStorm.
 * Date: 2018/01/17
 */

class GoodsEvaluationBean extends \Common\Bean\AbstractBean{

    protected $id;
    protected $prev_id;       //bigint(20) unsigned NOT NULL上级评论ID 用于追加
    protected $uid;           //char(40) NOT NULL评分人UID
    protected $goods_id;      //int(10) unsigned NOT NULL商品ID
    protected $seller_uid;    //char(40) NULL卖家UID
    protected $evaluate;      //char(20) NOT NULL评价 好中差评 positive/moderate/negative
    protected $point;         //decimal(3,1) unsigned NOT NULL是次得分
    protected $order_id;      //bigint(20) unsigned NOT NULL订单ID
    protected $order_no;      //char(30) NOT NULL订单号
    protected $change_time;   //datetime NULL修改时间
    protected $comment;       //char(255) NULL评价内容
    protected $status;        //tinyint(2) NOT NULL有效状态 -1无 1有
    protected $create_time;   //datetime NOT NULL创建(评分)时间

    protected $base_goods_id;      //int(10) unsigned NOT NULL商品ID

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
    public function getPrevId()
    {
        return $this->prev_id;
    }

    /**
     * @param mixed $prev_id
     */
    public function setPrevId($prev_id)
    {
        $this->prev_id = $prev_id;
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
    public function getGoodsId()
    {
        return $this->goods_id;
    }

    /**
     * @param mixed $goods_id
     */
    public function setGoodsId($goods_id)
    {
        $this->goods_id = $goods_id;
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
    public function getEvaluate()
    {
        return $this->evaluate;
    }

    /**
     * @param mixed $evaluate
     */
    public function setEvaluate($evaluate)
    {
        $this->evaluate = $evaluate;
    }

    /**
     * @return mixed
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param mixed $point
     */
    public function setPoint($point)
    {
        $this->point = $point;
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
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
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
    public function setOrderNo($order_no)
    {
        $this->order_no = $order_no;
    }

    /**
     * @return mixed
     */
    public function getChangeTime()
    {
        return $this->change_time;
    }

    /**
     * @param mixed $change_time
     */
    public function setChangeTime($change_time)
    {
        $this->change_time = $change_time;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
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
    public function getBaseGoodsId()
    {
        return $this->base_goods_id;
    }

    /**
     * @param mixed $base_goods_id
     */
    public function setBaseGoodsId($base_goods_id)
    {
        $this->base_goods_id = $base_goods_id;
    }

}