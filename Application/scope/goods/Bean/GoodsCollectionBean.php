<?php

namespace Goods\Bean;

/**
 * Created by PhpStorm.
 * Date: 2018/01/17
 */

class GoodsCollectionBean extends GoodsBean{

    protected $goods_id;

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

}