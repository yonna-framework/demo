<?php

namespace External\Model;

use Common\Map\IsSure;

class AbstractModel extends \Common\Model\AbstractModel
{

    /**
     * 初始化
     */
    public function init__()
    {
        parent::init__();
        $this->allowPermission(array(
            'External.Wxmp.getUserInfo',
            'External.Wxmp.qrcode',
            'External.Wxmp.getQrcodeData',
            'External.Wxmp.server1st',
            'External.Wxmp.server',

            'External.Alipay.directPay',
            'External.Alipay.directPayCallBack',
            'External.Alipay.wapV1',
            'External.Alipay.wapV1CallBack',
            'External.Alipay.wapV2',
            'External.Alipay.wapV2CallBack',

            'External.Wxpay.native',
            'External.Wxpay.jsapi',
            'External.Wxpay.h5',
            'External.Wxpay.callback',

            'External.TradeToken.getInfo',
        ));
    }

    const TIPS = '[已加密，修改请删除重置]';

    protected function hideStr($str = '')
    {
        $length = mb_strlen($str, 'utf-8');
        if ($length === 0) {
            return '<emptyset>';
        }
        $str = str_replace(['http://', 'https://'], '***', $str);
        $str = preg_replace("/\@(.*)/", '****', $str);
        $randStr = str_repeat('*', rand(3, 5)) . str_repeat('*', rand(3, 5));
        if ($length < 3) {
            return str_repeat('*', rand(3, 5));
        } elseif ($length < 7) {
            return mb_substr($str, 0, 1, 'utf-8') . $randStr . mb_substr($str, -1, 1, 'utf-8');
        } elseif ($length < 15) {
            return mb_substr($str, 0, 2, 'utf-8') . $randStr . mb_substr($str, -3, 3, 'utf-8');
        } else {
            return mb_substr($str, 0, 4, 'utf-8') . $randStr . mb_substr($str, -5, 5, 'utf-8');
        }
    }

    /**
     * 行为日志
     * @param $config
     * @param array $params
     * @param array $result
     * @param string $behaviour
     * @return bool
     */
    protected function log($config, array $params, array $result, string $behaviour = null)
    {
        if (!$behaviour) {
            $backtrace = debug_backtrace();
            if (count($backtrace) > 1) {
                $backtrace = $backtrace[1];
            } else {
                $backtrace = array_shift($backtrace);
            }
            $behaviour = $backtrace['class'] . '\\' . $backtrace['function'];
        }
        try {
            $this->db()->table('external_log')
                ->insert(array(
                    'create_time' => $this->db()->now(),
                    'behaviour' => $behaviour,
                    'config' => $config,
                    'config_actual' => $this->getActualConfig($config),
                    'params' => $params,
                    'result' => $result,
                ));
        } catch (\Exception $e) {
            return $this->false($e->getMessage());
        }
        return true;
    }


    //-------------------

    private function getExternalKV__($uid)
    {
        if (!$uid) {
            return $this->false('config not user');
        }
        $model = $this->db()->table('external_config');
        $model->equalTo('uid', $uid);
        $data = $model->one();
        if (empty($data)) {
            return $this->false('config not found');
        }
        $data = $data['external_config_data']['encode'];
        $data = $this->decrypto($data);
        $data = json_decode($data, true);
        $externalConfigKV = array();
        foreach ($data as $v) {
            $temp = array();
            foreach ($v['children'] as $vc) {
                $temp[$vc['key']] = $vc['data'];
                $temp[$vc['key'] . '_label'] = $vc['label'] ?? '';
            }
            $externalConfigKV[$v['key']] = $temp;
        }
        $externalConfigKV['external_config'] = $uid;
        return $externalConfigKV;
    }

    protected function getExternalKV($config, $autoDefault = false)
    {
        // 这个项目固定是 super admin UID
        $uid = CONFIG['admin_uid'];
        try {
            $this->redis()->hSet('ACTUAL_CONFIG', $config, $uid);
        } catch (\Exception $e) {
        }
        return $this->getExternalKV__($uid);
    }

    /**
     * 根据ID获取店铺CODE
     * @param $shopId
     * @return array|bool|null|string
     */
    protected function getCodeByShopId($shopId){
        if (empty($shopId)) return '';
        try {
            $shopInfo = $this->db()->table('erp_shop')->field('code')->equalTo('id', $shopId)->one();
            return $shopInfo['erp_shop_code'] ?? '';
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * 根据请求配置获取真实配置ID
     * @param $config
     * @return array|bool|null|string
     */
    protected function getActualConfig($config)
    {
        if (empty($config)) return '';
        try {
            return $this->redis()->hGet('ACTUAL_CONFIG', $config);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * 创建out单号
     * @param string $prev
     * @return string
     */
    protected function buildOutTradeNo($prev = 'OTN')
    {
        $str1 = $prev;
        $str1len = strlen($str1);
        $str2 = str_replace('.', '', microtime(true));
        $str2len = strlen($str2);
        $str3len = 19 - $str1len - $str2len;
        return $str1 . $str2 . ($str3len > 0 ? randCharNum($str3len) : '');
    }

    /**
     * 获取对外单信息
     * @param $tradeNo
     * @return bool
     */
    protected function getOutTradeInfo($tradeNo)
    {
        if (!$tradeNo) return null;
        $info = $this->db()->table('external_trade_token')->equalTo('out_trade_no', $tradeNo)->one();
        if (!$info || $info['external_trade_token_out_trade_no'] !== $tradeNo) return null;
        return $info;
    }

    /**
     * 检查对外单信息
     * @param $info
     * @return bool
     */
    protected function checkOutTradeInfo($info)
    {
        if ($info['external_trade_token_is_pay'] === IsSure::yes) {
            return $this->false('is payed');
        }
        $create_time = $info['external_trade_token_create_time'];
        $create_time = explode('.', $create_time);
        $create_time = reset($create_time);
        $create_timestamp = strtotime($create_time) + 86400 * 2;
        if ($create_timestamp < time()) { // 2天后就失效了，仅作记录使用
            return $this->false('invalid out trade');
        }
        return true;
    }

}