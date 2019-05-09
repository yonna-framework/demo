<?php
namespace Data\Bean;
/**
 * Date: 2017/08/28
 */

class BankLibBean extends \Common\Bean\AbstractBean{

    protected $code;         //银行代码
    protected $name;         //银行名称
    protected $icon_square;       //图标路径（正方）
    protected $icon_rectangle;    //图标路径（长方）
    protected $icon_circular;     //图标路径（圆形）
    protected $pay_code;          //支付代码
    protected $status;            //状态
    protected $ordering;

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getIconSquare()
    {
        return $this->icon_square;
    }

    /**
     * @param mixed $icon_square
     */
    public function setIconSquare($icon_square)
    {
        $this->icon_square = $icon_square;
    }

    /**
     * @return mixed
     */
    public function getIconRectangle()
    {
        return $this->icon_rectangle;
    }

    /**
     * @param mixed $icon_rectangle
     */
    public function setIconRectangle($icon_rectangle)
    {
        $this->icon_rectangle = $icon_rectangle;
    }

    /**
     * @return mixed
     */
    public function getIconCircular()
    {
        return $this->icon_circular;
    }

    /**
     * @param mixed $icon_circular
     */
    public function setIconCircular($icon_circular)
    {
        $this->icon_circular = $icon_circular;
    }

    /**
     * @return mixed
     */
    public function getPayCode()
    {
        return $this->pay_code;
    }

    /**
     * @param mixed $pay_code
     */
    public function setPayCode($pay_code)
    {
        $this->pay_code = $pay_code;
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
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param mixed $ordering
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;
    }

}