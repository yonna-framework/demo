<?php

namespace External\Model;

use Erp\Bean\ShopBean;
use Erp\Model\ShopModel;
use External\Bean\WxmpBean;
use External\Map\WxmpAccountType;
use External\Map\WxmpServerEncodeType;
use User\Bean\WechatBean;
use User\Model\WechatModel;

include_once PATH_PLUGINS . "/WxmpService/wxBizMsgCrypt.php";

class WxmpModel extends AbstractModel
{

    const TOKEN_COMMON = 'common';
    const TOKEN_USER = 'user';

    private $lastConfig = null;

    /**
     * @return WxmpBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * 获取AccessToken
     * @param $config
     * @return array|bool|null|string
     */
    private function getTokenAuthCommon($config)
    {
        if (!$config) return $this->false('not config');
        $this->lastConfig = $config;
        try {
            $accessToken = $this->redis()->get("WxmpModel#AccessToken#Common#{$config}");
            if (!$accessToken) {
                $externalConfigKV = $this->getExternalKV($config, true);
                if (empty($externalConfigKV)) {
                    return $this->false('错误配置');
                }
                $thisConfig = $externalConfigKV['wxmp'];
                if (!$thisConfig['appid']) return $this->false('无效的' . $thisConfig['appid_label']);
                if (!$thisConfig['secret']) return $this->false('无效的' . $thisConfig['secret_label']);
                if (!$thisConfig['account_type']) return $this->false('无效的' . $thisConfig['account_type_label']);
                $accessToken = null;
                if ($thisConfig['account_type'] == WxmpAccountType::qiyehao) {
                    // 如果是企业号用以下URL获取access_token
                    $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$thisConfig['appid']}&corpsecret={$thisConfig['secret']}";
                } elseif ($thisConfig['account_type'] == WxmpAccountType::fuwuhao) {
                    // 如果是服务号用以下URL获取access_token
                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$thisConfig['appid']}&secret={$thisConfig['secret']}";
                } elseif ($thisConfig['account_type'] == WxmpAccountType::dingyuehao) {
                    // 如果是订阅号，则禁止
                    throw new \Exception('订阅号不允许获取AccessToken');
                } else {
                    throw new \Exception('非法微信公众号账号类型');
                }
                $res = curlGet($url, 5.00);
                $res = json_decode($res);
                $accessToken = $res->access_token ?? null;
                if ($accessToken) {
                    $this->redis()->set("WxmpModel#AccessToken#Common#{$config}", $accessToken, $res->expires_in - 100);
                } else {

                    throw new \Exception($res->errmsg, $res->errcode);
                }
            }
        } catch (\Exception $e) {
            return $this->false($e->getMessage());
        }
        return $accessToken;
    }

    /**
     * 获取JsApiTicket
     * @param $config
     * @return mixed|null
     */
    private function getJsApiTicket($config)
    {
        if (!$config) return $this->false('not config');
        $this->lastConfig = $config;
        try {
            $ticket = $this->redis()->get("WxmpModel#JsApiTicket#{$config}");
            if (!$ticket) {
                $externalConfigKV = $this->getExternalKV($config, true);
                if (empty($externalConfigKV)) {
                    throw new \Exception('错误配置');
                }
                $thisConfig = $externalConfigKV['wxmp'];
                if (!$thisConfig['account_type']) {
                    throw new \Exception('无效的' . $thisConfig['account_type_label']);
                }
                $accessToken = $this->getTokenAuthCommon($config);
                if ($thisConfig['account_type'] == WxmpAccountType::qiyehao) {
                    // 如果是企业号用以下URL获取 ticket
                    $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=" . $accessToken;
                } elseif ($thisConfig['account_type'] == WxmpAccountType::fuwuhao) {
                    // 如果是服务号用以下URL获取 ticket
                    $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=" . $accessToken;
                } elseif ($thisConfig['account_type'] == WxmpAccountType::dingyuehao) {
                    // 如果是订阅号，则禁止
                    throw new \Exception('订阅号不允许获取 ticket');
                } else {
                    throw new \Exception('非法微信公众号账号类型');
                }
                $res = curlGet($url, 5.00);
                $res = json_decode($res);
                $ticket = $res->ticket ?? null;
                if ($ticket) {
                    $this->redis()->set("WxmpModel#JsApiTicket#{$config}", $accessToken, $res->expires_in - 100);
                } else {
                    if (isset($res->errcode) && $res->errcode != 0) {
                        if (strpos($res->errmsg, 'access_token is invalid or not latest') !== false) {
                            $this->clearToken(self::TOKEN_COMMON);
                            $ticket = $this->getJsApiTicket($config); // 清空token再来一回
                        }
                    } else {
                        throw new \Exception($res->errmsg, $res->errcode);
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->false($e->getMessage());
        }
        return $ticket;
    }

    /**
     * 获取 AccessToken
     * @param $config
     * @param null $wxCode
     * @return array|bool|null
     */
    private function getTokenAuthUserInfo($config, $wxCode = null)
    {
        if (!$config) return $this->false('config error');
        $this->lastConfig = $config;
        $externalConfigKV = $this->getExternalKV($config, true);
        if (empty($externalConfigKV)) {
            return $this->false('错误配置');
        }
        $thisConfig = $externalConfigKV['wxmp'];
        if (!$thisConfig['appid']) return $this->false('无效的' . $thisConfig['appid_label']);
        if (!$thisConfig['secret']) return $this->false('无效的' . $thisConfig['secret_label']);
        $accessToken = null;
        try {
            $accessToken = $this->redis()->get("WxmpModel#AccessToken#User{$this->getClientID()}{$config}");
            if (!$accessToken) {
                if (!$wxCode) {
                    return null;
                }
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$thisConfig['appid']}";
                $url .= "&secret={$thisConfig['secret']}";
                $url .= "&code={$wxCode}";
                $url .= "&grant_type=authorization_code";
                $accessToken = curlGet($url, 5.00);
                $accessToken = json_decode($accessToken, true);
                if (!empty($accessToken['errcode'])) {
                    return $this->false($accessToken['errcode']);
                }
                $this->redis()->set("WxmpModel#AccessToken#User{$this->getClientID()}{$config}", $accessToken, $accessToken['expires_in'] - 100);
            }
        } catch (\Exception $e) {
            return $this->false($e->getMessage());
        }
        return $accessToken;
    }

    /**
     * 清空缓存
     * @param null $type
     */
    private function clearToken($type = null)
    {
        if (!$this->lastConfig) return;
        try {
            switch ($type) {
                case self::TOKEN_COMMON:
                    $this->redis()->delete("WxmpModel#AccessToken#Common#{$this->lastConfig}");
                    break;
                case self::TOKEN_USER:
                    $this->redis()->delete("WxmpModel#AccessToken#User{$this->getClientID()}{$this->lastConfig}");
                    break;
                default:
                    $this->redis()->delete("WxmpModel#AccessToken#Common#{$this->lastConfig}");
                    $this->redis()->delete("WxmpModel#AccessToken#User{$this->getClientID()}{$this->lastConfig}");
                    break;
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * 获取
     * @return array|bool
     */
    public function getUserInfo()
    {
        $bean = $this->getBean();
        if (!$bean->getExternalConfig()) return $this->error('not config');
        $extra = $bean->getExtra() ?: array();
        $behaviour = $bean->getBehaviour();
        $action = null;
        switch ($behaviour) {
            case 'login.step1':
                if (!$bean->getReturnUrl()) return $this->error('not return url');
                $tokenAuth = $this->getTokenAuthUserInfo($bean->getExternalConfig());
                if ($tokenAuth === false) {
                    return $this->error($this->getFalseMsg());
                }
                if (!$tokenAuth) {
                    $action = 'login.step2';
                } else {
                    $action = 'login.step3';
                }
                break;
            case 'login.step2':
                if (!$bean->getCode()) return $this->error('not code');
                $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
                if (empty($externalConfigKV)) {
                    return $this->error('配置错误');
                }
                $tokenAuth = $this->getTokenAuthUserInfo($bean->getExternalConfig(), $bean->getCode());
                $action = 'login.step3';
                break;
            default:
                return $this->error('not allow');
                break;
        }
        switch ($action) {
            case 'login.step2': // 跳到步骤2
                $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
                if (empty($externalConfigKV)) {
                    return $this->error('配置错误');
                }
                $thisConfig = $externalConfigKV['wxmp'];
                if (!$thisConfig['appid']) return $this->error('无效的' . $thisConfig['appid_label']);
                $url = $this->getHost() . '/external/wxmpLoginStep2';
                $url .= '?return_url=' . urlencode($bean->getReturnUrl());
                $url .= '&platform=' . $this->getPlatform();
                $url .= '&client_id=' . $this->getClientID();
                $url .= '&external_config=' . $bean->getExternalConfig();
                $url .= '&extra=' . urlencode(json_encode($bean->getExtra()));
                //todo 微信配置
                $wxConf = array(
                    'appid' => $thisConfig['appid'],
                    'redirect_uri' => urlencode($url),
                    'response_type' => 'code',
                    'scope' => 'snsapi_userinfo',
                    'state' => $bean->getState() ?: randChar(10),
                );
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$wxConf['appid']}";
                $url .= "&redirect_uri={$wxConf['redirect_uri']}";
                $url .= "&response_type={$wxConf['response_type']}";
                $url .= "&scope={$wxConf['scope']}";
                $url .= "&state={$wxConf['state']}";
                $url .= "#wechat_redirect";
                return $this->success($url);
                break;
            case 'login.step3': // 获取微信数据，并自动注册登录
                // TODO 获取snsapi_userinfo
                if (!$tokenAuth) {
                    return $this->error('not tokenAuth');
                }
                $access_token = $tokenAuth['access_token'];
                //$expires_in = $tokenAuth['expires_in'];
                //$refresh_token = $tokenAuth['refresh_token'];
                $openid = $tokenAuth['openid'];
                //$scope = $tokenAuth['scope'];
                try {
                    $wxUserInfo = $this->redis()->get("WxmpModel#LoginStep3#{$openid}");
                    if (!$wxUserInfo) {
                        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
                        $wxUserInfo = curlGet($url, 5.00);
                        $wxUserInfo = json_decode($wxUserInfo, true);
                        if (isset($wxUserInfo['errcode'])) {
                            if (strpos($wxUserInfo['errmsg'], 'access_token is invalid or not latest') !== false) {
                                $this->clearToken(self::TOKEN_USER);
                                return $this->getUserInfo(); // retry
                            } else {
                                throw new \Exception($wxUserInfo['errcode']);
                            }
                        }
                        $this->redis()->set("WxmpModel#LoginStep3#{$openid}", $wxUserInfo, 300);
                    }
                } catch (\Exception $e) {
                    return $this->error($e->getMessage());
                }
                // todo 记录微信信息
                $actualConfig = $this->getActualConfig($bean->getExternalConfig());
                $wxData = array(
                    'unionid' => $wxUserInfo['unionid'] ?? '',
                    'sex' => $wxUserInfo['sex'],
                    'nickname' => $wxUserInfo['nickname'],
                    'avatar' => $wxUserInfo['headimgurl'],
                    'language' => $wxUserInfo['language'],
                    'city' => $wxUserInfo['city'],
                    'province' => $wxUserInfo['province'],
                    'country' => $wxUserInfo['country']
                );
                $one = $this->db()->table('external_wx_user_info')
                    ->field('open_id')
                    ->equalTo('config', $actualConfig)
                    ->equalTo('open_id', $wxUserInfo['openid'])
                    ->one();
                try {
                    if (!empty($one['external_wx_user_info_open_id']) && $one['external_wx_user_info_open_id'] == $wxUserInfo['openid']) {
                        $this->db()->table('external_wx_user_info')
                            ->equalTo('config', $actualConfig)
                            ->equalTo('open_id', $wxUserInfo['openid'])
                            ->update($wxData);
                    } else {
                        $wxData['config'] = $actualConfig;
                        $wxData['open_id'] = $wxUserInfo['openid'];
                        $this->db()->table('external_wx_user_info')->insert($wxData);
                    }
                } catch (\Exception $e) {
                    return $this->error($e->getMessage());
                }
                // 微信登录
                $wechatBean = new WechatBean();
                $wechatBean->setLoginName($extra['login_name'] ?? null);
                $wechatBean->setIdentityName($extra['identity_name'] ?? null);
                $wechatBean->setOpenId($wxUserInfo['openid']);
                $wechatBean->setUnionid($wxUserInfo['unionid'] ?? '');
                $wechatBean->setSex($wxUserInfo['sex']);
                $wechatBean->setLanguage($wxUserInfo['language']);
                $wechatBean->setNickname($wxUserInfo['nickname']);
                $wechatBean->setCity($wxUserInfo['city']);
                $wechatBean->setProvince($wxUserInfo['province']);
                $wechatBean->setCountry($wxUserInfo['country']);
                $wechatBean->setAvatar($wxUserInfo['headimgurl']);
                $wechatModel = new WechatModel($this->getIO());
                if (!$account = $wechatModel->wxLogin__($wechatBean)) {
                    return $this->error($wechatModel->getFalseMsg());
                }
                return $this->success($account);
                break;
            default:
                return $this->notFount('action not found');
                break;
        }
    }

    /**
     * 模板消息
     * bean templateMsg 格式：请参考 Wxmp.templateMsg.example
     * @param WxmpBean $bean
     * @return bool
     */
    public function templateMsg__(WxmpBean $bean)
    {
        if (!$bean->getTemplateMsgParams()) return $this->false('not data');
        $accessToken = $this->getTokenAuthCommon($bean->getExternalConfig());
        if (!$accessToken) {
            return $this->false($this->getFalseMsg());
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $accessToken;
        $result = curlPostStream($url, $bean->getTemplateMsgParams());
        if (!$result) {
            return $this->false('请求参数错误');
        }
        $result = json_decode($result, true);
        if ($result['errcode'] != 0) {
            if (strpos($result['errmsg'], 'access_token is invalid or not latest') !== false) {
                $this->clearToken(self::TOKEN_COMMON);
                return $this->templateMsg__($bean);
            } else {
                return $this->false($result['errmsg']);
            }
        }
        return $this->true('sent!');
    }

    /**
     * 客服消息
     * bean customMsg 格式：请参考 Wxmp.customMsg.example
     * @param WxmpBean $bean
     * @return bool
     */
    public function customMsg__(WxmpBean $bean)
    {
        if (!$bean->getCustomMsgParams()) return $this->false('not data');
        $accessToken = $this->getTokenAuthCommon($bean->getExternalConfig());
        if (!$accessToken) {
            return $this->false($this->getFalseMsg());
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $accessToken;
        $result = curlPostStream($url, $bean->getCustomMsgParams());
        if (!$result) {
            return $this->false('请求参数错误');
        }
        $result = json_decode($result, true);
        if ($result['errcode'] != 0) {
            if (strpos($result['errmsg'], 'access_token is invalid or not latest') !== false) {
                $this->clearToken(self::TOKEN_COMMON);
                return $this->customMsg__($bean);
            } else {
                return $this->false($result['errmsg']);
            }
        }
        return $this->true('sent!');
    }

    /**
     * 签名包
     * @param WxmpBean $bean
     * @return array|bool
     */
    public function getSignPackage__(WxmpBean $bean)
    {
        if (!$bean->getRequestUri()) return $this->false('not request uri');
        $jsApiTicket = $this->getJsApiTicket($bean->getExternalConfig());
        if (!$jsApiTicket) {
            return $this->false($this->getFalseMsg());
        }
        $url = $this->getHost() . $bean->getRequestUri();
        $timestamp = time();
        $nonceStr = randChar(16);
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsApiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1(trim($string));
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
        if (empty($externalConfigKV)) {
            return $this->false('错误配置');
        }
        $thisConfig = $externalConfigKV['wxmp'];
        $signPackage = array(
            "appId" => $thisConfig['appid'],
            "nonceStr" => $bean->getRequestUri(),
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string,
        );
        $this->log(
            $bean->getExternalConfig(),
            array(
                'jsapi_ticket' => $jsApiTicket,
                'noncestr' => $nonceStr,
                'timestamp' => $timestamp,
                'url' => $url,
            ),
            $signPackage
        );
        return $signPackage;
    }

    /**
     * 参数二维码
     * @return array
     */
    public function qrcode()
    {
        $bean = $this->getBean();
        if (!$bean->getQrcodeParams()) return $this->error('缺少 QrcodeParams');
        $qrp = json_decode($bean->getQrcodeParams(), true);
        if ($qrp['action_name'] == 'QR_SCENE' || $qrp['action_name'] == 'QR_STR_SCENE') {
            if ($qrp['expire_seconds'] < 30) {
                return $this->error('有效时间不能小于30秒');
            }
        }
        $qrp2 = $qrp;
        // 处理数据，微信各种长度限制
        if (isset($qrp['action_info']) && isset($qrp['action_info']['scene'])) {
            if (isset($qrp['action_info']['scene']['scene_str']) && $qrp['action_info']['scene']['scene_str']) {
                $qrp2['action_info']['scene']['scene_str'] = 'wxrz';
            } elseif (isset($qrp['action_info']['scene']['scene_id']) && $qrp['action_info']['scene']['scene_id']) {
                $qrp2['action_info']['scene']['scene_id'] = 1;
            }
        }
        $jsonQrp = json_encode($qrp2);
        $md5 = md5($jsonQrp);
        $result = null;
        try {
            $result = $this->redis()->get($md5);
            if (!$result) {
                $accessToken = $this->getTokenAuthCommon($bean->getExternalConfig());
                if (!$accessToken) {
                    throw new \Exception($this->getFalseMsg());
                }
                $sendUrl = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $accessToken;
                $result = curlPostStream($sendUrl, $jsonQrp);
                if (!$result) {
                    throw new \Exception('请求参数错误');
                }
                $result = json_decode($result, true);
                if (isset($result['errcode']) && $result['errcode'] != 0) {
                    if (strpos($result['errmsg'], 'access_token is invalid or not latest') !== false) {
                        $this->clearToken(self::TOKEN_COMMON);
                        return $this->qrcode();
                    } else {
                        throw new \Exception($result['errmsg']);
                    }
                } else {
                    $this->redis()->set($md5, $result, (int)$qrp['expire_seconds']);
                }
            }
            $expire = $result['expire_seconds'] - 5;
            //记录数据以供使用
            if (isset($qrp['action_info']) && isset($qrp['action_info']['scene'])) {
                if (isset($qrp['action_info']['scene']['scene_str']) && $qrp['action_info']['scene']['scene_str']) {
                    $this->redis()->set($result['url'], $qrp['action_info']['scene']['scene_str'], $expire);
                    $this->redis()->set($result['ticket'], $qrp['action_info']['scene']['scene_str'], $expire);
                } elseif (isset($qrp['action_info']['scene']['scene_id']) && $qrp['action_info']['scene']['scene_id']) {
                    $this->redis()->set($result['url'], $qrp['action_info']['scene']['scene_id'], $expire);
                    $this->redis()->set($result['ticket'], $qrp['action_info']['scene']['scene_id'], $expire);
                }
            }
            $this->log($bean->getExternalConfig(), $qrp, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        if (!$result) {
            return $this->error('not result');
        }
        return $this->success($result);
    }

    /**
     * 参数二维码
     * @return array
     */
    public function getQrcodeData()
    {
        $bean = $this->getBean();
        if (!$bean->getQrcodeRecordKey()) return $this->error('缺少 key');
        $result = null;
        try {
            $result = $this->redis()->get($bean->getQrcodeRecordKey());
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        $this->log('system', $bean->toArray(), array('data' => $result));
        return $this->success($result);
    }

    /**
     * 同步自定义菜单
     * @return array
     */
    public function diyMenu()
    {
        $bean = $this->getBean();
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
        if (empty($externalConfigKV)) {
            return $this->error('错误配置');
        }
        $thisConfig = $externalConfigKV['wxmp'];
        $accessToken = $this->getTokenAuthCommon($bean->getExternalConfig());
        if (!$accessToken) {
            return $this->error($this->getFalseMsg());
        }
        $diyMenuData = $thisConfig['diy_menu'] ?? null;
        if (!$diyMenuData) {
            return $this->error('菜单数据未设置');
        }
        $diyMenuDataArr = json_decode($diyMenuData, true);
        if (!$diyMenuDataArr) {
            return $this->error('菜单数据格式错误');
        }
        $sendUrl = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $accessToken;
        $result = curlPostStream($sendUrl, $diyMenuData);
        $result = json_decode($result,true);
        if (!$result) {
            return $this->error('腾讯接口无回应或调试地址非可访问域名');//需要上线测试，IP白名单都不允许，会返回false
        }
        $this->log($bean->getExternalConfig(), $bean->toArray(), array('menu' => $diyMenuDataArr, 'result' => $result));
        if(!empty($result['errmsg']) && $result['errmsg'] === 'ok'){
            return $this->success($result);
        }
        $errmsg = $result['errmsg'] ?? 'unknow';
        return $this->error($errmsg);
    }






    // TODO SERVER

    /**
     * 服务器接收
     * @param $text
     * @param $config
     * @return bool|mixed
     */
    private function serverReceive($text, $config)
    {
        switch ($config['encodeType']) {
            case WxmpServerEncodeType::security:
                $crypt = new \WXBizMsgCrypt($config['token'], $config['encodingAesKey'], $config['appId']);
                $xml_tree = new \DOMDocument();
                $xml_tree->loadXML($text);
                $array_e = $xml_tree->getElementsByTagName('Encrypt');
                $encrypt = $array_e->item(0)->nodeValue;
                $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
                $from_xml = sprintf($format, $encrypt);
                // 第三方 收到 公众号平台发送的消息
                $msg = '';
                $errCode = $crypt->decryptMsg($config['msgSignature'], $config['timestamp'], $config['nonce'], $from_xml, $msg);
                if ($errCode == 0) {
                    $msg = str_replace('<![CDATA[', '', $msg);
                    $msg = str_replace(']]>', '', $msg);
                    $result = json_decode(json_encode(simplexml_load_string($msg)), true);
                    return $result;
                } else {
                    return $this->false('receive fail: ' . $errCode);
                }
                break;
            default:
                return $this->false('Not support encodeType except ' . WxmpServerEncodeType::security);
                break;
        }
    }

    /**
     * 服务器发送
     * @param $text
     * @param $config
     * @return bool|string
     */
    private function serverSend($text, $config)
    {
        switch ($config['encodeType']) {
            case WxmpServerEncodeType::security:
                $crypt = new \WXBizMsgCrypt($config['token'], $config['encodingAesKey'], $config['appId']);
                $encryptMsg = '';
                $errCode = $crypt->encryptMsg($text, $config['timestamp'], $config['nonce'], $encryptMsg);
                if ($errCode == 0) {
                    return $encryptMsg;
                } else {
                    return $this->false('send fail');
                }
                break;
            default:
                return $this->false('Not support encodeType except ' . WxmpServerEncodeType::security);
                break;
        }
    }

    /**
     *  公众号服务器第一次校验
     * @return array
     */
    public function server1st()
    {
        $bean = $this->getBean();
        if (!$bean->getTimestamp()) return $this->error('not timestamp');
        if (!$bean->getNonce()) return $this->error('not nonce');
        if (!$bean->getSignature()) return $this->error('not signature');
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
        if (empty($externalConfigKV)) {
            return $this->error('错误配置');
        }
        $thisConfig = $externalConfigKV['wxmp'];
        if (empty($thisConfig['service_token'])) return $this->error('无效的' . $thisConfig['service_token_label']);
        //
        $tmpArr = array($thisConfig['service_token'], $bean->getTimestamp(), $bean->getNonce());
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        $this->log($bean->getExternalConfig(), $bean->toArray(), array('tmpStr' => $tmpStr));
        if ($tmpStr == $bean->getSignature()) {
            return $this->success();
        } else {
            return $this->error('invalid signature');
        }
    }

    /**
     * 公众号服务器后续入口
     * @return array
     */
    public function server()
    {
        $bean = $this->getBean();
        if (!$bean->getBehaviour()) return $this->error('not input');
        if (!$bean->getTimestamp()) return $this->error('not timestamp');
        if (!$bean->getNonce()) return $this->error('not nonce');
        if (!$bean->getMsgSignature()) return $this->error('not msg_signature');
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
        if (empty($externalConfigKV)) {
            return $this->error('错误配置');
        }
        $thisConfig = $externalConfigKV['wxmp'];
        if (empty($thisConfig['appid'])) return $this->error('无效的' . $thisConfig['appid_label']);
        if (empty($thisConfig['service_token'])) return $this->error('无效的' . $thisConfig['service_token_label']);
        if (empty($thisConfig['service_encodingaeskey'])) return $this->error('无效的' . $thisConfig['service_encodingaeskey_label']);
        if (empty($thisConfig['service_encode_type'])) return $this->error('无效的' . $thisConfig['service_encode_type_label']);
        $receive = $this->serverReceive($bean->getBehaviour(), array(
            'token' => $thisConfig['service_token'],
            'encodingAesKey' => $thisConfig['service_encodingaeskey'],
            'encodeType' => $thisConfig['service_encode_type'],
            'appId' => $thisConfig['appid'],
            'msgSignature' => $bean->getMsgSignature(),
            'timestamp' => $bean->getTimestamp(),
            'nonce' => $bean->getNonce(),
        ));
        if (!$receive) {
            return $this->error($this->getFalseMsg());
        }
        $event = strtoupper($receive['Event']);
        $eventKey = $receive['EventKey'];
        $Ticket = $receive['Ticket'] ?? null;
        $notify_url = null;
        $xml_url = null;
        $notifyData = array();
        $this->log(
            $bean->getExternalConfig(),
            array('input' => $bean->toArray()),
            array('receive' => $receive)
        );
        // 在SCAN及关注情况下，如果有eventKey,检测里面有没有 notify_url ,有的话把结果抛过去
        if ($eventKey && ($event == 'SUBSCRIBE' || $event == 'SCAN')) {
            if ($event == 'SUBSCRIBE') {
                $eventKey = str_replace('qrscene_', '', $eventKey);
            }
            $eventKey = json_decode($eventKey, true);
            $TicketCache = null;
            if (isset($eventKey['notify_url']) && $eventKey['notify_url']) {
                $notify_url = $eventKey['notify_url'];
                $receive['EventKey'] = json_encode($eventKey);
                if (isset($eventKey['xml_url']) && $eventKey['xml_url']) {
                    $xml_url = $eventKey['xml_url'];
                }
            } elseif ($Ticket) {
                try {
                    $TicketCache = $this->redis()->get($Ticket);
                } catch (\Exception $e) {
                    $TicketCache = null;
                }
                if ($TicketCache) {
                    $TicketCache = json_decode($TicketCache, true);
                    if (isset($TicketCache['notify_url']) && $TicketCache['notify_url']) {
                        $notify_url = $TicketCache['notify_url'];
                        $receive['EventKey'] = json_encode($TicketCache);
                    }
                    if (isset($TicketCache['xml_url']) && $TicketCache['xml_url']) {
                        $xml_url = $TicketCache['xml_url'];
                    }
                }
            }
            if ($notify_url) {
                $this->log(
                    $bean->getExternalConfig(),
                    array('ticket' => $Ticket, 'notify_url' => $notify_url),
                    array('receive' => $receive, 'ticket_cache' => $TicketCache)
                );
                curlPost($notify_url, $receive, 1);
            }
        }

        //todo 以 [ config + event + openid ] 记录数据以供serviceData使用
        if ($event && $notifyData && !empty($receive['FromUserName'])) {
            try {
                $this->redis()->set($bean->getExternalConfig() . $event . $receive['FromUserName'], $notifyData, 300);
            } catch (\Exception $e) {

            }
        }
        //根据不同的event，自动回复
        $send = null;
        switch ($event) {
            case 'SUBSCRIBE':
                $send = $thisConfig['service_reply_subscribe'] ?? null;
                break;
            case 'UNSUBSCRIBE':
                $send = $thisConfig['service_reply_unsubscribe'] ?? null;
                break;
            case 'SCAN':
                $send = $thisConfig['service_reply_scan'] ?? null;
                break;
        }
        if ($send) {
            if ($xml_url) {
                $send = str_replace('$XML_URL', $xml_url, $send);
            }
            //替换部分字段
            $send = str_replace('<![CDATA[CreateTime]]>', time(), $send);
            $send = str_replace('<![CDATA[ToUserName]]>', '<![CDATA[' . $receive['FromUserName'] . ']]>', $send);
            $send = str_replace('<![CDATA[FromUserName]]>', '<![CDATA[' . $receive['ToUserName'] . ']]>', $send);
            $this->log(
                $bean->getExternalConfig(),
                array('action' => 'send', 'ticket' => $Ticket, 'notify_url' => $notify_url),
                array('send' => $send)
            );
            $sendResult = $this->serverSend($send, array(
                'token' => $thisConfig['service_token'],
                'encodingAesKey' => $thisConfig['service_encodingaeskey'],
                'encodeType' => $thisConfig['service_encode_type'],
                'appId' => $thisConfig['appid'],
                'msgSignature' => $bean->getMsgSignature(),
                'timestamp' => $bean->getTimestamp(),
                'nonce' => $bean->getNonce(),
            ));
            if (!$sendResult) {
                return $this->error($this->getFalseMsg());
            }
            return $this->success($sendResult);
        }
        return $this->success('success');
    }


}