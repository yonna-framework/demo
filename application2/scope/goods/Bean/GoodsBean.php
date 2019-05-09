<?php
namespace Goods\Bean;
/**
 * @date: 2018/01/07
 */

class GoodsBean extends \Common\Bean\AbstractBean {

    protected $id; //自增ID';
    protected $uid; //卖家uid';
    protected $status; //商品状态 -10删除 -1下架 1上架';
    protected $name; //商品名称';
    protected $groups;// 联合';
    protected $category_id; //分类ID组';
    protected $brand_id; //品牌id';
    protected $attr_value; //相关属性值ID';
    protected $attr_value_label; //相关属性值';
    protected $detail; //商品详情（如introduce简介，各类型文章详情等）';
    protected $pic; //图集';
    protected $tag; //商品标签';
    protected $origin_region; //产地地区ID';
    protected $origin_region_label; //产地地区';
    protected $origin_address; //产地详细';
    protected $unit; //单位';
    protected $price_sell; //销售价';
    protected $price_cost; //成本价';
    protected $price_advice; //建议售价';
    protected $qty_stock; //库存量';
    protected $qty_view; //浏览次数';
    protected $qty_sale; //销量';
    protected $qty_like; //赞次数';
    protected $weight; //重量,单位千克kg';
    protected $barcode; //条码';
    protected $recommend; //推荐判断组';
    protected $ordering; //排序 越大越靠前';
    protected $create_time; //创建时间';
    protected $update_time;

    protected $seller_account;

    // new lv
    protected $month;
    protected $monthString;
    protected $student_grade;
    protected $student_uid;

    // search
    protected $name_eng;
    protected $country;

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
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id): void
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * @param mixed $brand_id
     */
    public function setBrandId($brand_id): void
    {
        $this->brand_id = $brand_id;
    }

    /**
     * @return mixed
     */
    public function getAttrValue()
    {
        return $this->attr_value;
    }

    /**
     * @param mixed $attr_value
     */
    public function setAttrValue($attr_value): void
    {
        $this->attr_value = $attr_value;
    }

    /**
     * @return mixed
     */
    public function getAttrValueLabel()
    {
        return $this->attr_value_label;
    }

    /**
     * @param mixed $attr_value_label
     */
    public function setAttrValueLabel($attr_value_label): void
    {
        $this->attr_value_label = $attr_value_label;
    }

    /**
     * @return mixed
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param mixed $detail
     */
    public function setDetail($detail): void
    {
        $this->detail = $detail;
    }

    /**
     * @return mixed
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * @param mixed $pic
     */
    public function setPic($pic): void
    {
        $this->pic = $pic;
    }

    /**
     * @return mixed
     */
    public function getPriceSell()
    {
        return $this->price_sell;
    }

    /**
     * @param mixed $price_sell
     */
    public function setPriceSell($price_sell): void
    {
        $this->price_sell = $price_sell;
    }

    /**
     * @return mixed
     */
    public function getPriceAdvice()
    {
        return $this->price_advice;
    }

    /**
     * @param mixed $price_advice
     */
    public function setPriceAdvice($price_advice): void
    {
        $this->price_advice = $price_advice;
    }

    /**
     * @return mixed
     */
    public function getQtyStock()
    {
        return $this->qty_stock;
    }

    /**
     * @param mixed $qty_stock
     */
    public function setQtyStock($qty_stock): void
    {
        $this->qty_stock = $qty_stock;
    }

    /**
     * @return mixed
     */
    public function getQtyView()
    {
        return $this->qty_view;
    }

    /**
     * @param mixed $qty_view
     */
    public function setQtyView($qty_view): void
    {
        $this->qty_view = $qty_view;
    }

    /**
     * @return mixed
     */
    public function getQtySale()
    {
        return $this->qty_sale;
    }

    /**
     * @param mixed $qty_sale
     */
    public function setQtySale($qty_sale): void
    {
        $this->qty_sale = $qty_sale;
    }

    /**
     * @return mixed
     */
    public function getQtyLike()
    {
        return $this->qty_like;
    }

    /**
     * @param mixed $qty_like
     */
    public function setQtyLike($qty_like): void
    {
        $this->qty_like = $qty_like;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @return mixed
     */
    public function getOriginRegion()
    {
        return $this->origin_region;
    }

    /**
     * @param mixed $origin_region
     */
    public function setOriginRegion($origin_region): void
    {
        $this->origin_region = $origin_region;
    }

    /**
     * @return mixed
     */
    public function getOriginRegionLabel()
    {
        return $this->origin_region_label;
    }

    /**
     * @param mixed $origin_region_label
     */
    public function setOriginRegionLabel($origin_region_label): void
    {
        $this->origin_region_label = $origin_region_label;
    }

    /**
     * @return mixed
     */
    public function getOriginAddress()
    {
        return $this->origin_address;
    }

    /**
     * @param mixed $origin_address
     */
    public function setOriginAddress($origin_address): void
    {
        $this->origin_address = $origin_address;
    }

    /**
     * @return mixed
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param mixed $barcode
     */
    public function setBarcode($barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * @return mixed
     */
    public function getRecommend()
    {
        return $this->recommend;
    }

    /**
     * @param mixed $recommend
     */
    public function setRecommend($recommend): void
    {
        $this->recommend = $recommend;
    }

    /**
     * @return mixed
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param mixed $ordering
     */
    public function setOrdering($ordering): void
    {
        $this->ordering = $ordering;
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
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    /**
     * @param mixed $update_time
     */
    public function setUpdateTime($update_time): void
    {
        $this->update_time = $update_time;
    }

    /**
     * @return mixed
     */
    public function getNameEng()
    {
        return $this->name_eng;
    }

    /**
     * @param mixed $name_eng
     */
    public function setNameEng($name_eng): void
    {
        $this->name_eng = $name_eng;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getSellerAccount()
    {
        return $this->seller_account;
    }

    /**
     * @param mixed $seller_account
     */
    public function setSellerAccount($seller_account): void
    {
        $this->seller_account = $seller_account;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups): void
    {
        $this->groups = $groups;
    }

    /**
     * @return mixed
     */
    public function getPriceCost()
    {
        return $this->price_cost;
    }

    /**
     * @param mixed $price_cost
     */
    public function setPriceCost($price_cost): void
    {
        $this->price_cost = $price_cost;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month): void
    {
        $this->month = $month;
    }

    /**
     * @return mixed
     */
    public function getMonthString()
    {
        return $this->monthString;
    }

    /**
     * @param mixed $monthString
     */
    public function setMonthString($monthString): void
    {
        $this->monthString = $monthString;
    }

    /**
     * @return mixed
     */
    public function getStudentGrade()
    {
        return $this->student_grade;
    }

    /**
     * @param mixed $student_grade
     */
    public function setStudentGrade($student_grade): void
    {
        $this->student_grade = $student_grade;
    }

    /**
     * @return mixed
     */
    public function getStudentUid()
    {
        return $this->student_uid;
    }

    /**
     * @param mixed $student_uid
     */
    public function setStudentUid($student_uid): void
    {
        $this->student_uid = $student_uid;
    }


}