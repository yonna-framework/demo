<?php

namespace External\Model;

use plugins\Alidayu\Sms;
use External\Bean\AlidayuBean;
use External\Map\AlidayuSmsType;

class AlidayuModel extends AbstractModel
{

    /**
     * @return AlidayuBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     *  发送短信
     * @param AlidayuBean $bean
     * @return boolean
     */
    public function sms__(AlidayuBean $bean)
    {
        if (!$bean->getMobile()) return $this->false('缺少手机号');
        if (!isMobile($bean->getMobile())) return $this->false('错误的手机号');
        if (!$bean->getType()) return $this->false('缺少类型');
        if (!$bean->getContent()) return $this->false('缺少内容');
        $smsTypeMap = (new AlidayuSmsType())->getMap();
        $smsType = array_column($smsTypeMap, 'value');
        if (!in_array($bean->getType(), $smsType)) {
            return $this->false('不受支持的类型');
        }
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), $bean->isAutoDefault());
        if (empty($externalConfigKV)) {
            return $this->false('配置错误');
        }
        $thisConfig = $externalConfigKV['alidayu_sms'];
        if (!$thisConfig['appkey']) return $this->false('无效的' . $thisConfig['appkey_label']);
        if (!$thisConfig['appsecret']) return $this->false('无效的' . $thisConfig['appsecret_label']);
        if (!$thisConfig['sms_sign']) return $this->false('无效的' . $thisConfig['sms_sign_label']);
        if (!$thisConfig['sms_tpl_code_' . $bean->getType()]) return $this->false('无效的' . $thisConfig['sms_tpl_code_' . $bean->getType() . '_label']);
        $sc = $this->db()->table('system_data')->equalTo('key', 'system_config')->one();
        $name = '平台';
        if ($sc && !empty($sc['system_data_data']) && is_array($sc['system_data_data'])) {
            foreach ($sc['system_data_data'] as $v) {
                if ($v['key'] === 'project_name') {
                    $name = $v['value'];
                    break;
                }
            }
        }
        $ac = (new Sms());
        $res = $ac->sendSms(
            $thisConfig['appkey'],
            $thisConfig['appsecret'],
            $bean->getMobile(),
            $thisConfig['sms_sign'],
            $thisConfig['sms_tpl_code_' . $bean->getType()],
            json_encode(array(
                'code' => $bean->getContent(),
                'product' => $name,
            ))
        );
        if (!$res) {
            return $this->false($ac->getError());
        }
        $this->log(
            $bean->getExternalConfig(),
            array(
                'appkey' => $thisConfig['appkey'],
                'appsecret' => $thisConfig['appsecret'],
                'mobile' => $bean->getMobile(),
                'sms_sign' => $thisConfig['sms_sign'],
                'sms_tpl' => $thisConfig['sms_tpl_code_' . $bean->getType()],
                'msg' => array(
                    'code' => $bean->getContent(),
                    'product' => $name,
                )
            ),
            $res ?  array('result' => 'ok') : array('error' => $ac->getError())
        );
        return $this->true('sent!');
    }

}