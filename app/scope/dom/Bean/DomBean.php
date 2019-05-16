<?php
namespace Dom\Bean;

/**
 * 文档Bean
 * @date 2017/03/31
 */

class DomBean extends \Common\Bean\AbstractBean {

	protected $id;					//int(12) unsigned NOT NULL文档id
	protected $type;			//int(11) NULL文档类型
	protected $category_key;			//int(11) NULL文档分类id
	protected $ordering;				//int(10) NOT NULL排序，数值越大优先级越高
	protected $status;				//tinyint(3) NULL文档状态
	protected $views;					//int(12) unsigned NOT NULL浏览量
	protected $create_time;			//datetime NULL创建时间
	protected $update_time;			//datetime NULL更新时间
	protected $data;				//longtext NULL文档数据（序列化一大堆的数据）
	protected $uid;					//int(12) NOT NULL创建的用户ID
	protected $verify_uid;			//int(12) NOT NULL审核的用户ID

	//search
	protected $category_name;
	protected $category_parent_id;
	protected $has_img;

	protected $addslashes;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCategoryKey()
    {
        return $this->category_key;
    }

    /**
     * @param mixed $category_key
     */
    public function setCategoryKey($category_key): void
    {
        $this->category_key = $category_key;
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
    public function setData($data): void
    {
        $this->data = $data;
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
	public function getViews()
	{
		return $this->views;
	}

	/**
	 * @param mixed $views
	 */
	public function setViews($views)
	{
		$this->views = $views;
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
	public function getUpdateTime()
	{
		return $this->update_time;
	}

	/**
	 * @param mixed $update_time
	 */
	public function setUpdateTime($update_time)
	{
		$this->update_time = $update_time;
	}

	/**
	 * @return mixed
	 */
	public function getHasImg()
	{
		return $this->has_img;
	}

	/**
	 * @param mixed $has_img
	 */
	public function setHasImg($has_img)
	{
		$this->has_img = $has_img;
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
	public function getVerifyUid()
	{
		return $this->verify_uid;
	}

	/**
	 * @param mixed $verify_uid
	 */
	public function setVerifyUid($verify_uid)
	{
		$this->verify_uid = $verify_uid;
	}

	/**
	 * @return mixed
	 */
	public function getCategoryName()
	{
		return $this->category_name;
	}

	/**
	 * @param mixed $category_name
	 */
	public function setCategoryName($category_name)
	{
		$this->category_name = $category_name;
	}

	/**
	 * @return mixed
	 */
	public function getCategoryParentId()
	{
		return $this->category_parent_id;
	}

	/**
	 * @param mixed $category_parent_id
	 */
	public function setCategoryParentId($category_parent_id)
	{
		$this->category_parent_id = $category_parent_id;
	}

	/**
	 * @return mixed
	 */
	public function getAddslashes()
	{
		return $this->addslashes;
	}

	/**
	 * @param mixed $addslashes
	 */
	public function setAddslashes($addslashes)
	{
		$this->addslashes = $addslashes;
	}

}