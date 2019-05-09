<?php
/**
 * 自定义IP查询方法
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2017/12/21
 */
namespace Data\Helper;

use Common\Helper\AbstractHelper;

class IpTaobao extends AbstractHelper {

	//Config 配置部分
	const API_URL='http://ip.taobao.com/service/getIpInfo.php';

	//错误容器
	private $ipStack = array();

    /**
     * @param $ip
     * @param null $rect
     * @param int $timeout
     * @return bool|string
     */
	public function Ip($ip,$rect=null,$timeout=10){
		if(empty($ip)){
			return $this->false('Parameter ip must be present');
		}
		if(!isset($this->ipStack[$ip])){
            //CURL
            $curl = curl_init();
            curl_setopt($curl,CURLOPT_URL,self::API_URL."?ip=".$ip);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($curl,CURLOPT_HEADER,0);
            curl_setopt($curl,CURLOPT_TIMEOUT,$timeout);
            if(!$result=curl_exec($curl)){
                $error = curl_error($curl);
                curl_close($curl);
                return $this->false($error);
            }
            curl_close($curl);
            $result = json_decode($result,true);
            $this->ipStack[$ip] = $result;
        }
		else{
			$result = $this->ipStack[$ip];
		}

		if($result['code'] == 0){
			$data = $result['data'];

			$areaStr = '';
			if(!$rect){
				$areaStr = $data["country"].$data["area"].$data["region"].$data["city"].$data["isp"];
			}else{
				(strpos($rect,'country')!==false)	&& $areaStr .= $data["country"];
				(strpos($rect,'area')!==false) 		&& $areaStr .= $data["area"];
				(strpos($rect,'region')!==false)	    && $areaStr .= $data["region"];
				(strpos($rect,'city')!==false) 		&& $areaStr .= $data["city"];
				(strpos($rect,'isp')!==false) 		&& $areaStr .= $data["isp"];
			}
			if(!$areaStr) $areaStr = '未分配或者内网IP';
			return $areaStr;
		}else{
			return $this->false('fail - ip');
		}
	}

}