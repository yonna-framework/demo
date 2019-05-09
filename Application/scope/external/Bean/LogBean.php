<?php
namespace External\Bean;
/**
 * Date: 2018/10/24
 */
class LogBean extends \Common\Bean\AbstractBean
{

    protected $create_time;// 创建时间';
    protected $behaviour;// 操作';
    protected $config;
    protected $config_actual;
    protected $params;// 参数';
    protected $result;// 结果';

    /**
     * @return mixed
     */
    public function getBehaviour()
    {
        return $this->behaviour;
    }

    /**
     * @param mixed $behaviour
     */
    public function setBehaviour($behaviour): void
    {
        $this->behaviour = $behaviour;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config): void
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getConfigActual()
    {
        return $this->config_actual;
    }

    /**
     * @param mixed $config_actual
     */
    public function setConfigActual($config_actual): void
    {
        $this->config_actual = $config_actual;
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
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params): void
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }

}