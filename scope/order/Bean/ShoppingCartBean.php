<?php
namespace Order\Bean;

class ShoppingCartBean extends AbstractBean{

    protected $id;                //bigint(20) unsigned NOT NULL
    protected $uid;               //char(40) NOT NULL会员id
    protected $goods_id;          //int(10) unsigned NOT NULL商品id
    protected $qty;               //int(10) unsigned NOT NULL购买数量

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
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param mixed $qty
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

}
