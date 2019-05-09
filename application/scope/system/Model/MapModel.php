<?php
/**
 * @ate: 2018/10/12
 */
namespace System\Model;

class MapModel extends AbstractModel {

    /**
     * @return \System\Bean\MapBean
     */
    protected function getBean(){
        return parent::getBean();
    }

    /**
     * 获取 MAP [ {v,l},{v,l} ]
     * @return array
     */
    public function getMap(){
        $mapKey = $this->getBean()->getMapKey();
        $mapName = $this->getBean()->getMapName();
        if(!$mapKey || !$mapName){
            return $this->error('参数错误');
        }else{
            $mapKey = ucfirst($mapKey);
            $mapName = ucfirst($mapName);
        }
        $mapRes = '\\'.$mapKey.'\\Map\\'.$mapName;
        if(class_exists($mapRes)){
            return $this->success((new $mapRes())->getMap());
        }
        return $this->error('值对不存在');
    }

    /**
     * 获取 KV { k:v }
     * @return array
     */
    public function getKV(){
        $mapKey = $this->getBean()->getMapKey();
        $mapName = $this->getBean()->getMapName();
        if(!$mapKey || !$mapName){
            return $this->error('参数错误');
        }else{
            $mapKey = ucfirst($mapKey);
            $mapName = ucfirst($mapName);
        }
        $mapRes = '\\'.$mapKey.'\\Map\\'.$mapName;
        if(class_exists($mapRes)){
            return $this->success((new $mapRes())->getKV());
        }
        return $this->error('值对不存在');
    }

}