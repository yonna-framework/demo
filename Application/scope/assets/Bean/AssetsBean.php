<?php

namespace Assets\Bean;

class AssetsBean extends \Common\Bean\AbstractBean{

    protected $hash_id; //hash_id';
    protected $hash_file_name; //hash文件名';
    protected $file_name; //文件名';
    protected $file_ext; //文件后缀';
    protected $file_size; //文件大小';
    protected $content_type; //内容类型';
    protected $path; //存在路径';
    protected $from_url; //来源地址';
    protected $download_url; //下载地址';
    protected $call_qty; //调用次数';
    protected $call_last_time; //最后一次调用时间';
    protected $uid; //拥有者';
    protected $create_time; //创建日期';
    protected $update_time;

    protected $check_level = false;

    /**
     * @return mixed
     */
    public function getHashId()
    {
        return $this->hash_id;
    }

    /**
     * @param mixed $hash_id
     */
    public function setHashId($hash_id): void
    {
        $this->hash_id = $hash_id;
    }

    /**
     * @return mixed
     */
    public function getHashFileName()
    {
        return $this->hash_file_name;
    }

    /**
     * @param mixed $hash_file_name
     */
    public function setHashFileName($hash_file_name): void
    {
        $this->hash_file_name = $hash_file_name;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     */
    public function setFileName($file_name): void
    {
        $this->file_name = $file_name;
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

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * @param mixed $file_size
     */
    public function setFileSize($file_size): void
    {
        $this->file_size = $file_size;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * @param mixed $content_type
     */
    public function setContentType($content_type): void
    {
        $this->content_type = $content_type;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getFromUrl()
    {
        return $this->from_url;
    }

    /**
     * @param mixed $from_url
     */
    public function setFromUrl($from_url): void
    {
        $this->from_url = $from_url;
    }

    /**
     * @return mixed
     */
    public function getDownloadUrl()
    {
        return $this->download_url;
    }

    /**
     * @param mixed $download_url
     */
    public function setDownloadUrl($download_url): void
    {
        $this->download_url = $download_url;
    }

    /**
     * @return mixed
     */
    public function getCallQty()
    {
        return $this->call_qty;
    }

    /**
     * @param mixed $call_qty
     */
    public function setCallQty($call_qty): void
    {
        $this->call_qty = $call_qty;
    }

    /**
     * @return mixed
     */
    public function getCallLastTime()
    {
        return $this->call_last_time;
    }

    /**
     * @param mixed $call_last_time
     */
    public function setCallLastTime($call_last_time): void
    {
        $this->call_last_time = $call_last_time;
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
     * @return bool
     */
    public function isCheckLevel(): bool
    {
        return $this->check_level;
    }

    /**
     * @param bool $check_level
     */
    public function setCheckLevel(bool $check_level): void
    {
        $this->check_level = $check_level;
    }

}