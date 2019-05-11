<?php
/**
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2017/12/20
 */
namespace Data\Helper;

class IpHelper extends IpTaobao {

    private $ip = null;

    public function setIP($ip){
        $this->ip = $ip;
    }

    /**
     * 获取IP地址全称
     * @return bool
     */
    public function getFullName(){
        return $this->getTaobaoData();
    }

    /**
     * 获取IP国家名
     * @return array|bool|mixed
     */
    public function getCountryName(){
        $data = $this->getTaobaoData('country');
        if($data) return $data;
        else return $this->false($this->getFalseMsg());
    }

    /**
     * 获取IP区域名
     * @return array|bool|mixed
     */
    public function getAreaName(){
        $data = $this->getTaobaoData('area');
        if($data) return $data;
        else return $this->false($this->getFalseMsg());
    }

    /**
     * 获取IP地区名
     * @return array|bool|mixed
     */
    public function getRegionName(){
        $data = $this->getTaobaoData('region');
        if($data) return $data;
        else return $this->false($this->getFalseMsg());
    }

    /**
     * 获取IP城市名
     * @return array|bool|mixed
     */
    public function getCityName(){
        $data = $this->getTaobaoData('city');
        if($data) return $data;
        else return $this->false($this->getFalseMsg());
    }

    /**
     * 获取IP服务商
     * @return array|bool|mixed
     */
    public function getIspName(){
        $data = $this->getTaobaoData('isp');
        if($data) return $data;
        else return $this->false($this->getFalseMsg());
    }

    /**
     * 调用TAOBAO接口获取数据
     * @param null $rect
     * @return bool|string
     */
    private function getTaobaoData($rect=null){
        if(!$this->ip){
            return $this->false('must set ip');
        }
        if(!$result = $this->Ip($this->ip,$rect)){
            return $this->false($this->getFalseMsg());
        }
        return $result;
    }

}