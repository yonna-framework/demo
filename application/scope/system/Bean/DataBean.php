<?php
namespace System\Bean;

/**
 * Date: 2018/06/28
 */

class DataBean extends \Common\Bean\AbstractBean{

    protected $key; //key
    protected $name; //名称
    protected $data; //数据

    protected $format_type;

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
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
    public function setName($name)
    {
        $this->name = $name;
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
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getFormatType()
    {
        return $this->format_type;
    }

    /**
     * @param mixed $format_type
     */
    public function setFormatType($format_type)
    {
        $this->format_type = $format_type;
    }

}