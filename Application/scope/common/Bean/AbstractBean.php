<?php
namespace Common\Bean;

abstract class AbstractBean{

    protected $limit;             //限制条数
    protected $offset;            //从这个开始算起
    protected $orderBy;           //排序
    protected $groupBy;           //组
    protected $having;            //having
    protected $joinTable;         //联表

    //TODO 分页
    protected $page;              //开启分页
    protected $pagePer;           //每页显示条数
    protected $pageCurrent;       //当前页数

    protected $tokenCode;         //token码
    protected $authName;          //验证名
    protected $authCode;          //验证码
    protected $newAuthCode;       //新验证码(特殊用途)

    // 权限
    protected $authUid;               //验证UID,这个UID用于检查权限，最好不与其余命名重复,不使用UID的原因是有的方法需要使用UID作为数据传输

    // 统计
    protected $statTimeRange;
    // excel
    protected $excel;
    // lang
    protected $language;


    /**
     * @return mixed
     */
    public function getLimit()
    {
        return (int)$this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return (int)$this->offset;
    }

    /**
     * @param mixed $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return mixed
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param mixed $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return mixed
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * @param mixed $groupBy
     */
    public function setGroupBy($groupBy)
    {
        $this->groupBy = $groupBy;
    }

    /**
     * @return mixed
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * @param mixed $having
     */
    public function setHaving($having)
    {
        $this->having = $having;
    }

    /**
     * @return mixed
     */
    public function getJoinTable()
    {
        return (array)$this->joinTable;
    }

    /**
     * @param mixed $joinTable
     */
    public function setJoinTable($joinTable)
    {
        $this->joinTable = $joinTable;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page ? true : false;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getPagePer()
    {
        return (int)$this->pagePer;
    }

    /**
     * @param mixed $pagePer
     */
    public function setPagePer($pagePer)
    {
        $this->pagePer = $pagePer;
    }

    /**
     * @return mixed
     */
    public function getPageCurrent()
    {
        return (int)$this->pageCurrent;
    }

    /**
     * @param mixed $pageCurrent
     */
    public function setPageCurrent($pageCurrent)
    {
        $this->pageCurrent = $pageCurrent;
    }

    /**
     * @return mixed
     */
    public function getTokenCode()
    {
        return $this->tokenCode;
    }

    /**
     * @param mixed $tokenCode
     */
    public function setTokenCode($tokenCode)
    {
        $this->tokenCode = $tokenCode;
    }

    /**
     * @return mixed
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * @param mixed $authCode
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;
    }

    /**
     * @return mixed
     */
    public function getAuthName()
    {
        return $this->authName;
    }

    /**
     * @param mixed $authName
     */
    public function setAuthName($authName)
    {
        $this->authName = $authName;
    }

    /**
     * @return mixed
     */
    public function getNewAuthCode()
    {
        return $this->newAuthCode;
    }

    /**
     * @param mixed $newAuthCode
     */
    public function setNewAuthCode($newAuthCode)
    {
        $this->newAuthCode = $newAuthCode;
    }

    /**
     * @return mixed
     */
    public function getAuthUid()
    {
        return $this->authUid;
    }

    /**
     * @param mixed $authUid
     */
    public function setAuthUid($authUid)
    {
        $this->authUid = $authUid;
    }

    /**
     * @return mixed
     */
    public function getStatTimeRange()
    {
        return $this->statTimeRange;
    }

    /**
     * @param mixed $statTimeRange
     */
    public function setStatTimeRange($statTimeRange)
    {
        $this->statTimeRange = $statTimeRange;
    }

    /**
     * @return mixed
     */
    public function getExcel()
    {
        return $this->excel;
    }

    /**
     * @param mixed $excel
     */
    public function setExcel($excel)
    {
        $this->excel = $excel;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }














    /**
     * 返回当前对象的所有属性名值对数组，子类要返回的属性不能为protected
     * @author hunzsig
     * @param boolean $noNull 是否过滤===NULL的值
     * @return array
     */
    public function toArray($noNull = false){
        if($noNull){
            $arr = get_object_vars($this);
            $arr = array_filter($arr, function($v){
                return !is_null($v);
            });
            return $arr;
        }else{
            return get_object_vars($this);
        }
    }

    /**
     * 重置
     * @return $this new
     */
    public function reSet(){
        return new $this();
    }

}