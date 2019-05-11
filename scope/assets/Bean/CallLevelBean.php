<?php

namespace Assets\Bean;

class CallLevelBean extends \Common\Bean\AbstractBean
{

    protected $lv; //等级';
    protected $lv_as; //等级等价物';
    protected $lv_desc; //等级描述';
    protected $file_size_unit; //文件大小单位';
    protected $file_max_total_size; //允许的总体文件大小';
    protected $file_max_simple_size; //允许的单个文件大小';
    protected $file_max_qty; //允许的文件数';
    protected $file_ext; //允许的文件后缀';

    /**
     * @return mixed
     */
    public function getLv()
    {
        return $this->lv;
    }

    /**
     * @param mixed $lv
     */
    public function setLv($lv): void
    {
        $this->lv = $lv;
    }

    /**
     * @return mixed
     */
    public function getLvAs()
    {
        return $this->lv_as;
    }

    /**
     * @param mixed $lv_as
     */
    public function setLvAs($lv_as): void
    {
        $this->lv_as = $lv_as;
    }

    /**
     * @return mixed
     */
    public function getLvDesc()
    {
        return $this->lv_desc;
    }

    /**
     * @param mixed $lv_desc
     */
    public function setLvDesc($lv_desc): void
    {
        $this->lv_desc = $lv_desc;
    }

    /**
     * @return mixed
     */
    public function getFileSizeUnit()
    {
        return $this->file_size_unit;
    }

    /**
     * @param mixed $file_size_unit
     */
    public function setFileSizeUnit($file_size_unit): void
    {
        $this->file_size_unit = $file_size_unit;
    }

    /**
     * @return mixed
     */
    public function getFileMaxTotalSize()
    {
        return $this->file_max_total_size;
    }

    /**
     * @param mixed $file_max_total_size
     */
    public function setFileMaxTotalSize($file_max_total_size): void
    {
        $this->file_max_total_size = $file_max_total_size;
    }

    /**
     * @return mixed
     */
    public function getFileMaxSimpleSize()
    {
        return $this->file_max_simple_size;
    }

    /**
     * @param mixed $file_max_simple_size
     */
    public function setFileMaxSimpleSize($file_max_simple_size): void
    {
        $this->file_max_simple_size = $file_max_simple_size;
    }

    /**
     * @return mixed
     */
    public function getFileMaxQty()
    {
        return $this->file_max_qty;
    }

    /**
     * @param mixed $file_max_qty
     */
    public function setFileMaxQty($file_max_qty): void
    {
        $this->file_max_qty = $file_max_qty;
    }

    /**
     * @return mixed
     */
    public function getFileExt()
    {
        return $this->file_ext;
    }

    /**
     * @param mixed $file_ext
     */
    public function setFileExt($file_ext): void
    {
        $this->file_ext = $file_ext;
    }

}