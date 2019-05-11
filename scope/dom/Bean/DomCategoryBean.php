<?php
namespace Dom\Bean;
/**
 * 文档分类Bean
 * @date 2017/03/31
 */

class DomCategoryBean extends \Common\Bean\AbstractBean {

	protected $key;
	protected $name;			//varchar(250) NOT NULL分类名称
	protected $description;	//varchar(255) NULL描述
	protected $pic;			//varchar(1024) NULL分类图片
	protected $status;		//tinyint(4) NULL是否开启 -1不开启 1开启

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
    public function setKey($key): void
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
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
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
	public function setPic($pic)
	{
		$this->pic = $pic;
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



}