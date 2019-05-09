<?php
namespace Goods\Bean;
/**
 * @date: 2018/09/29
 */
class GoodsAttrValueBean extends \Common\Bean\AbstractBean {

    protected $id; // 自增ID';
    protected $name;
    protected $class_id;
    protected $pic;

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
    public function getClassId()
    {
        return $this->class_id;
    }

    /**
     * @param mixed $class_id
     */
    public function setClassId($class_id): void
    {
        $this->class_id = $class_id;
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

}