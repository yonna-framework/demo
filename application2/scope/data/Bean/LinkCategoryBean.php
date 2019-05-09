<?php
namespace Data\Bean;
/**
 * 文档分类Bean
 * @date 2018/01/07
 */

class LinkCategoryBean extends \Common\Bean\AbstractBean{

	protected $id;			//id
	protected $parent_id;		//int(11) NOT NULL父级id
	protected $name;			//varchar(250) NOT NULL分类名称
	protected $level;	        //int(11) NULL分类等级
	protected $description;	//varchar(255) NULL描述
	protected $pic;			//varchar(1024) NULL分类图片
	protected $status;		//tinyint(4) NULL是否开启 -1不开启 1开启

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
	public function getParentId()
	{
		return $this->parent_id;
	}

	/**
	 * @param mixed $parent_id
	 */
	public function setParentId($parent_id)
	{
		$this->parent_id = $parent_id;
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
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
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