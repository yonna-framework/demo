<?php

namespace External\Model;

use External\Map\AliyunSmsType;
use plugins\Aliyun\Sms;
use External\Bean\AliyunBean;

class AliyunModel extends AbstractModel
{

    /**
     * @return AliyunBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * @param AliyunBean $bean
     * @return bool
     */
    public function sms__(AliyunBean $bean)
    {
        if (!$bean->getMobile()) return $this->false('缺少手机号');
        if (!isMobile($bean->getMobile())) return $this->false('错误的手机号');
        if (!$bean->getType()) return $this->false('缺少类型');
        if (!$bean->getContent()) return $this->false('缺少内容');
        $smsTypeMap = (new AliyunSmsType())->getMap();
        $smsType = array_column($smsTypeMap, 'value');
        if (!in_array($bean->getType(), $smsType)) {
            return $this->false('不受支持的类型');
        }
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), $bean->isAutoDefault());
        if(empty($externalConfigKV)){
            return $this->false('配置错误');
        }
        $thisConfig = $externalConfigKV['aliyun_sms'];
        if (!$thisConfig['appkey']) return $this->false('无效的' . $thisConfig['appkey_label']);
        if (!$thisConfig['secretkey']) return $this->false('无效的' . $thisConfig['secretkey_label']);
        if (!$thisConfig['sms_sign']) return $this->false('无效的' . $thisConfig['sms_sign_label']);
        if (!$thisConfig['sms_tpl_code_' . $bean->getType()]) return $this->false('无效的' . $thisConfig['sms_tpl_code_' . $bean->getType() . '_label']);
        $res = (new Sms())->sendSms(
            $thisConfig['appkey'],
            $thisConfig['secretkey'],
            $thisConfig['sms_sign'],
            $thisConfig['sms_tpl_code_' . $bean->getType()],
            $bean->getMobile(),
            json_encode(array(
                'code' => $bean->getContent(),
            ))
        );
        $this->log(
            $bean->getExternalConfig(),
            array(
                'appkey' => $thisConfig['appkey'],
                'secretkey' => $thisConfig['secretkey'],
                'mobile' => $bean->getMobile(),
                'sms_sign' => $thisConfig['sms_sign'],
                'sms_tpl' => $thisConfig['sms_tpl_code_' . $bean->getType()],
                'msg' => array(
                    'code' => $bean->getContent(),
                )
            ),
            $res
        );
        if(isset($res['Code']) && $res['Code'] == 'OK'){
            return $this->true('sent!');
        }
        return $this->false($res['Message']);
    }

}