<?php

namespace External\Model;

use Common\Map\IsSure;
use External\Map\WxmpAccountType;
use External\Map\WxmpServerEncodeType;

class ConfigModel extends AbstractModel
{

    /**
     * @return \External\Bean\ConfigBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * 获取
     * @return array
     */
    public function get()
    {
        $bean = $this->getBean();
        if ($bean->getAuthUid() != $bean->getUid()) {
            $authUserInfo = $this->db()->table('user')->field('platform')->equalTo('uid', $bean->getAuthUid())->one();
            if ($bean->getAuthUid() != CONFIG['admin_uid'] && !in_array('admin', $authUserInfo['user_platform'])) {
                return $this->error('auth error');
            }
            $uid = $bean->getUid();
        } else {
            $uid = $bean->getAuthUid();
        }
        if (!$uid) return $this->error('用户错误');
        $model = $this->db()->table('external_config');
        $model->equalTo('uid', $uid);
        $data = $model->one();
        if (!$data) {
            $isSure = (new IsSure())->getMap();
            $wxmpAccountType = (new WxmpAccountType())->getMap();
            $wxmpServerEncodeType = (new WxmpServerEncodeType())->getMap();
            $default = array(
                array(
                    'key' => 'email', 'label' => '邮件服务(c)',
                    'children' => array(
                        array('key' => 'smtp_host', 'label' => 'SMTP服务器的名称', 'data' => ''),
                        array('key' => 'smtp_port', 'label' => 'SMTP服务器端口', 'data' => ''),
                        array('key' => 'smtp_auth', 'label' => 'SMTP是否启用认证', 'data' => '1', 'map' => $isSure),
                        array('key' => 'username', 'label' => '发件邮箱名', 'data' => ''),
                        array('key' => 'from_address', 'label' => '发件人地址', 'data' => ''),
                        array('key' => 'from_name', 'label' => '发件人姓名', 'data' => ''),
                        array('key' => 'password', 'label' => '客户端授权密码', 'data' => ''),
                        array('key' => 'charset', 'label' => '设置邮件内容编码', 'data' => ''),
                        array('key' => 'ishtml', 'label' => '邮件内容是否HTML格式邮件', 'data' => '1', 'map' => $isSure),
                    ),
                ),
                array(
                    'key' => 'wxmp', 'label' => '微信公众号',
                    'children' => array(
                        array('key' => 'mp_sign_url', 'label' => '网页授权域名(复制到公众号设置-功能设置-网页授权域名)', 'data' => str_replace(['http://', 'https://'], '', $this->getHost()), 'is_fixed' => 1),
                        array('key' => 'service_url', 'label' => '服务器配置-URL(复制到基本配置-服务器地址)', 'data' => $this->getHost() . '/external/wxmpServer' . $uid, 'is_fixed' => 1),
                        array('key' => 'appid', 'label' => 'APP ID', 'data' => ''),
                        array('key' => 'secret', 'label' => 'SECRET', 'data' => ''),
                        array('key' => 'account_type', 'label' => '账号类型', 'data' => 'fuwuhao', 'map' => $wxmpAccountType),
                        array('key' => 'service_token', 'label' => '服务器配置-Token', 'data' => ''),
                        array('key' => 'service_encodingaeskey', 'label' => '服务器配置-EncodingAESKey(43位)', 'data' => ''),
                        array('key' => 'service_encode_type', 'label' => '消息加解密方式(设置基本配置-服务器配置-消息加解密方式为『安全模式（推荐）』)', 'data' => 'security', 'map' => $wxmpServerEncodeType),
                        array('key' => 'service_reply_subscribe', 'label' => '服务回复(on关注)', 'data' => '', 'is_origin' => 1),
                        array('key' => 'service_reply_unsubscribe', 'label' => '服务回复(on取消关注)', 'data' => '', 'is_origin' => 1),
                        array('key' => 'service_reply_scan', 'label' => '服务回复(on扫描参数二维码)', 'data' => '', 'is_origin' => 1),
                        array('key' => 'diy_menu', 'label' => 'DIY菜单数据', 'data' => '', 'is_origin' => 1),
                    )
                ),
                array(
                    'key' => 'wxpay', 'label' => '微信支付',
                    'children' => array(
                        array('key' => 'pay_auth_url', 'label' => '支付配置公众号授权地址(复制到商户平台-产品中心-公众号支付-支付授权目录)', 'data' => $this->getHost() . '/external/', 'is_fixed' => 1),
                        array('key' => 'pay_auth_domain', 'label' => '支付配置H5支付(复制到商户平台-产品中心-H5支付-H5支付域名)', 'data' => $this->getDomain(), 'is_fixed' => 1),
                        array('key' => 'appid', 'label' => '绑定支付的APPID（必须配置，开户邮件中可查看）', 'data' => ''),
                        array('key' => 'mchid', 'label' => '商户号（必须配置，开户邮件中可查看）', 'data' => ''),
                        array('key' => 'key', 'label' => '商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）', 'data' => ''),
                        array('key' => 'appsecret', 'label' => '公众帐号secert', 'data' => ''),
                        array('key' => 'ssl_cert', 'label' => '商户证书(apiclient_cert.pem)', 'data' => '', 'is_file' => 1),
                        array('key' => 'ssl_key', 'label' => '商户证书(apiclient_key.pem)', 'data' => '', 'is_file' => 1),
                        array('key' => 'ssl_ca', 'label' => '商户证书(rootca.pem)', 'data' => '', 'is_file' => 1),
                    ),
                ),
                array(
                    'key' => 'alidayu_sms', 'label' => '阿里大鱼短信',
                    'children' => array(
                        array('key' => 'appkey', 'label' => 'AppKey', 'data' => ''),
                        array('key' => 'appsecret', 'label' => 'AppSecret', 'data' => ''),
                        array('key' => 'sms_sign', 'label' => '短信签名', 'data' => ''),
                        array('key' => 'sms_tpl_code_identity', 'label' => '短信模板（身份验证验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_login', 'label' => '短信模板（登录确认验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_login_exception', 'label' => '短信模板（登录异常验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_register', 'label' => '短信模板（用户注册验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_change_pwd', 'label' => '短信模板（修改密码验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_change_pay_pwd', 'label' => '短信模板（修改支付密码验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_change_info', 'label' => '短信模板（信息变更验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_event', 'label' => '短信模板（活动确认验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_bing_wx', 'label' => '短信模板（绑定微信验证码）', 'data' => ''),
                    ),
                ),
                array(
                    'key' => 'aliyun_sms', 'label' => '阿里云短信',
                    'children' => array(
                        array('key' => 'appkey', 'label' => 'AppKey', 'data' => ''),
                        array('key' => 'secretkey', 'label' => 'SecretKey', 'data' => ''),
                        array('key' => 'sms_sign', 'label' => '短信签名', 'data' => ''),
                        array('key' => 'sms_tpl_code_identity', 'label' => '短信模板（身份验证验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_login', 'label' => '短信模板（登录确认验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_login_exception', 'label' => '短信模板（登录异常验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_register', 'label' => '短信模板（用户注册验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_change_pwd', 'label' => '短信模板（修改密码验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_change_pay_pwd', 'label' => '短信模板（修改支付密码验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_change_info', 'label' => '短信模板（信息变更验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_event', 'label' => '短信模板（活动确认验证码）', 'data' => ''),
                        array('key' => 'sms_tpl_code_bing_wx', 'label' => '短信模板（绑定微信验证码）', 'data' => ''),
                    ),
                ),
                array(
                    'key' => 'alipay_direct_pay', 'label' => '支付宝-即时到帐',
                    'children' => array(
                        array('key' => 'partner', 'label' => '合作身份者id，以2088开头的16位纯数字', 'data' => ''),
                        array('key' => 'seller_email', 'label' => '收款支付宝账号', 'data' => ''),
                        array('key' => '32_key', 'label' => '安全检验码，以数字和字母组成的32位字符', 'data' => ''),
                        array('key' => 'cacert', 'label' => 'ca证书路径文件(cacert.pem)', 'data' => '', 'is_file' => 1),
                    ),
                ),
                array(
                    'key' => 'alipay_wap_v1', 'label' => '支付宝-手机支付(v1)',
                    'children' => array(
                        array('key' => 'partner', 'label' => '合作身份者id，以2088开头的16位纯数字', 'data' => ''),
                        array('key' => 'seller_id', 'label' => '商家帐号id，以2088开头的16位纯数字', 'data' => ''),
                        array('key' => 'cacert', 'label' => 'ca证书路径文件(cacert.pem)', 'data' => '', 'is_file' => 1),
                        array('key' => 'private_key', 'label' => '商户的私钥文件(rsa_private_key.pem)', 'data' => '', 'is_file' => 1),
                        array('key' => 'ali_public_key', 'label' => '支付宝公钥文件(alipay_public_key.pem)', 'data' => '', 'is_file' => 1),
                    ),
                ),
                array(
                    'key' => 'alipay_wap_v2', 'label' => '支付宝-手机支付(v2)',
                    'children' => array(
                        array('key' => 'app_id', 'label' => 'APP ID', 'data' => ''),
                        array('key' => 'private_key', 'label' => '商户的私钥(字符串去头尾)', 'data' => ''),
                        array('key' => 'public_key', 'label' => '商户的公钥(字符串去头尾)', 'data' => ''),
                        array('key' => 'ali_public_key', 'label' => '支付宝公钥(字符串去头尾)', 'data' => ''),
                        array('key' => 'aes_encrypt_key', 'label' => 'AES密钥(字符串)', 'data' => ''),
                    ),
                ),
                array(
                    'key' => 'chuanglan253', 'label' => '创蓝253云通讯',
                    'children' => array(
                        array('key' => 'api_account', 'label' => '账号 Account', 'data' => ''),
                        array('key' => 'api_password', 'label' => '密码 Password', 'data' => ''),
                        array('key' => 'api_sign', 'label' => '签名 Sign', 'data' => ''),
                    ),
                ),
            );
            try {
                $this->db()->table('external_config')->insert(array(
                    'uid' => $uid,
                    'data' => array('encode' => $this->encrypto(json_encode($default))),
                ));
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
            $data = $default;
        } else {
            $data = $data['external_config_data']['encode'];
            $data = $this->decrypto($data);
            $data = json_decode($data, true);
        }
        foreach ($data as $k => $v) {
            foreach ($v['children'] as $kk => $vv) {
                if (!empty($vv['is_hidden']) && $vv['is_hidden'] == 1) {
                    unset($data[$k]['children'][$kk]);
                    continue;
                }
                if (!empty($vv['is_fixed']) && $vv['is_fixed'] == 1) {
                    $data[$k]['children'][$kk]['hide'] = $vv['data'];
                    continue;
                }
                if (!empty($vv['is_file']) && $vv['is_file'] == 1) {
                    $path = false;
                    foreach ($v['children'] as $vvv) {
                        if ($vvv['key'] === $vv['key'] . '_path') {
                            $path = true;
                            $data[$k]['children'][$kk]['hide'] = empty($vvv['data']) ? $this->hideStr() : '<file already>';
                            break;
                        }
                    }
                    if (!$path) $data[$k]['children'][$kk]['hide'] = $this->hideStr();
                    continue;
                }
                if (!empty($vv['is_origin']) && $vv['is_origin'] == 1) {
                    $data[$k]['children'][$kk]['hide'] = $this->hideStr($vv['data']);
                    $data[$k]['children'][$kk]['data'] = $vv['data'];
                    continue;
                }
                if ($vv['data']) {
                    if (!empty($vv['map'])) {
                        continue;
                    }
                    $data[$k]['children'][$kk]['hide'] = $this->hideStr($vv['data']);
                    $data[$k]['children'][$kk]['data'] = self::TIPS . $this->encrypto($vv['data']);
                    continue;
                }
                $data[$k]['children'][$kk]['hide'] = $this->hideStr();
                $data[$k]['children'][$kk]['data'] = self::TIPS . $this->encrypto('');
            }
        }
        return $this->success($data);
    }

    /**
     * 更新数据
     * @return array
     */
    public function save()
    {
        $bean = $this->getBean();
        if ($bean->getAuthUid() != $bean->getUid()) {
            $authUserInfo = $this->db()->table('user')->field('platform')->equalTo('uid', $bean->getAuthUid())->one();
            if ($bean->getAuthUid() != CONFIG['admin_uid'] && !in_array('admin', $authUserInfo['user_platform'])) {
                return $this->error('auth error');
            }
            $uid = $bean->getUid();
        } else {
            $uid = $bean->getAuthUid();
        }
        $old = $this->db()->table('external_config')->equalTo('uid', $uid)->one();
        if ($old && !empty($old['external_config_data']) && !empty($old['external_config_data']['encode'])) {
            $old = $old['external_config_data']['encode'];
            $old = $this->decrypto($old);
            $old = json_decode($old, true);
            $nold = array();
            foreach ($old as $v) {
                $nold[$v['key']] = $v;
                $temp = array();
                foreach ($v['children'] as $vc) {
                    $temp[$vc['key']] = $vc;
                }
                $nold[$v['key']]['children'] = $temp;
            }
        }
        $data = array();
        if ($bean->getData()) {
            $tempData = $bean->getData();
            foreach ($tempData as $k => $v) {
                foreach ($v['children'] as $kk => $vv) {
                    if (isset($vv['hide'])) unset($tempData[$k]['children'][$kk]['hide']);
                    if (isset($vv['prevIndex'])) unset($tempData[$k]['children'][$kk]['prevIndex']);
                    if ($vv['data']) {
                        if (is_array($vv['data'])) {
                            if (!empty($vv['is_file']) && $vv['is_file'] == 1) {
                                $tempData[$k]['children'][$kk]['data'] = '';
                                $dlUrl = $vv['data'][0]['downloadURL'];
                                $dlUrl = explode('/', $dlUrl);
                                unset($dlUrl[0]);
                                unset($dlUrl[1]);
                                unset($dlUrl[2]);
                                unset($dlUrl[3]);
                                $dlUrl = realpath(PATH_UPLOAD . DIRECTORY_SEPARATOR . implode('/', $dlUrl)); // upload path
                                $tempData[$k]['children'][] = array(
                                    'is_hidden' => 1,
                                    'key' => $vv['key'] . '_path',
                                    'data' => $dlUrl,
                                );
                            }
                        } else if (strpos($vv['data'], self::TIPS) !== false) { // 原版重置
                            $tempData[$k]['children'][$kk]['data'] = str_replace(self::TIPS, '', $tempData[$k]['children'][$kk]['data']);
                            $tempData[$k]['children'][$kk]['data'] = $this->decrypto($tempData[$k]['children'][$kk]['data']);
                        }
                    } else {
                        if (!empty($vv['is_file']) && $vv['is_file'] == 1 && isset($nold[$v['key']]['children'][$vv['key'] . '_path'])) {
                            $tempData[$k]['children'][] = $nold[$v['key']]['children'][$vv['key'] . '_path'];
                        }
                    }
                }
            }
            $data['data'] = array('encode' => $this->encrypto(json_encode($tempData)));
        }
        if ($data) {
            try {
                $this->db()->table('external_config')->equalTo('uid', $uid)->update($data);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return $this->success();
    }

}