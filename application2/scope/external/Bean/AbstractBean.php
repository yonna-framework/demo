<?php
namespace External\Bean;

abstract class AbstractBean extends \Common\Bean\AbstractBean {

    protected $external_config;
    protected $auto_default = true;

    protected $extra;

    /**
     * @return mixed
     */
    public function getExternalConfig()
    {
        return $this->external_config;
    }

    /**
     * @param mixed $external_config
     */
    public function setExternalConfig($external_config): void
    {
        $this->external_config = $external_config;
    }

    /**
     * @return bool
     */
    public function isAutoDefault(): bool
    {
        return $this->auto_default;
    }

    /**
     * @param bool $auto_default
     */
    public function setAutoDefault(bool $auto_default): void
    {
        $this->auto_default = $auto_default;
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param mixed $extra
     */
    public function setExtra($extra): void
    {
        $this->extra = $extra;
    }

}