<?php

namespace User\Bean;


class OnlineBean extends InfoBean {

    protected $ip;                    //char(50) NOT NULLip
    protected $login_time;            //datetime NOT NULL登录时间
    protected $active_time;           //datetime NULL活动时间
    protected $expire_time;           //datetime NOT NULL过期时间

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getLoginTime()
    {
        return $this->login_time;
    }

    /**
     * @param mixed $login_time
     */
    public function setLoginTime($login_time)
    {
        $this->login_time = $login_time;
    }

    /**
     * @return mixed
     */
    public function getActiveTime()
    {
        return $this->active_time;
    }

    /**
     * @param mixed $active_time
     */
    public function setActiveTime($active_time)
    {
        $this->active_time = $active_time;
    }

    /**
     * @return mixed
     */
    public function getExpireTime()
    {
        return $this->expire_time;
    }

    /**
     * @param mixed $expire_time
     */
    public function setExpireTime($expire_time)
    {
        $this->expire_time = $expire_time;
    }

}