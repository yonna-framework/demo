<?php

namespace External\Model;

use External\Bean\Chuanglan253Bean;
use plugins\Chuanglan253\Sms;

class Chuanglan253Model extends AbstractModel
{

    /**
     * @return Chuanglan253Bean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * @param Chuanglan253Bean $bean
     * @return bool
     */
    public function sms__(Chuanglan253Bean $bean)
    {
        if (!$bean->getMobile()) return $this->false('缺少手机号');
        if (!isMobile($bean->getMobile())) return $this->false('错误的手机号');
        if (!$bean->getContent()) return $this->false('缺少内容');

        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), $bean->isAutoDefault());
        if(empty($externalConfigKV)){
            return $this->false('配置错误');
        }
        $thisConfig = $externalConfigKV['chuanglan253'];
        if (!$thisConfig['api_account']) return $this->false('无效的' . $thisConfig['api_account_label']);
        if (!$thisConfig['api_password']) return $this->false('无效的' . $thisConfig['api_password_label']);
        if (!$thisConfig['api_sign']) return $this->false('无效的' . $thisConfig['api_sign_label']);

        $ytx = (new Sms($thisConfig['api_account'], $thisConfig['api_password'], $thisConfig['api_sign']));
        $result = $ytx->sendSMS($bean->getMobile(), $bean->getContent());
        $result = $ytx->execResult($result);
        if (isset($result[1]) && $result[1] == 0) {
            //
        } else {
            return $this->false("发送失败" . $ytx->falseCode[$result[1]] ?? '');
        }
        return $this->true('sent!');
    }

}