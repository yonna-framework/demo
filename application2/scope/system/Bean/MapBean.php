<?php

namespace System\Bean;

/**
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2015/10/14
 * Time: 15:21
 */

class MapBean extends \Common\Bean\AbstractBean{

    protected $mapKey;
    protected $mapName;

    /**
     * @return mixed
     */
    public function getMapKey()
    {
        return $this->mapKey;
    }

    /**
     * @param mixed $mapKey
     */
    public function setMapKey($mapKey)
    {
        $this->mapKey = $mapKey;
    }

    /**
     * @return mixed
     */
    public function getMapName()
    {
        return $this->mapName;
    }

    /**
     * @param mixed $mapName
     */
    public function setMapName($mapName)
    {
        $this->mapName = $mapName;
    }

}