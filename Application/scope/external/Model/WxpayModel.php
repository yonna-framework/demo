<?php

namespace External\Model;

use Common\Map\IsSure;
use Order\Bean\OrderBean;
use Order\Map\PayStatus;
use External\Bean\WxpayBean;
use Order\Map\PayType;
use Order\Model\OrderModel;
use plugins\Wxpay\Core\Data\WxPayDataBase;
use plugins\Wxpay\Core\Data\WxPayResults;
use plugins\Wxpay\Core\Data\WxPayUnifiedOrder;
use plugins\Wxpay\Core\WxPayApi;
use plugins\Wxpay\WxPayJsApiPay;
use plugins\Wxpay\WxPayNativePay;

class WxpayModel extends AbstractModel
{

    /**
     * @return WxpayBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * 金额 - 请求时
     * @param $totalFee
     * @return int
     */
    private function totalFeeQuery($totalFee)
    {
        if (!$totalFee) return 0;
        return $totalFee * 100;
    }

    /**
     * 金额 - 回调时
     * @param $totalFee
     * @return int
     */
    private function totalFeeNotify($totalFee)
    {
        if (!$totalFee) return 0;
        return $totalFee / 100;
    }

    /**
     * 根据订单号获取订单信息
     * @param $orderNo
     * @return array|bool
     */
    protected function getOrderInfo($orderNo)
    {
        if (!$orderNo) return $this->false('订单号错误');
        $orderInfo = $this->db()->table('order')->field('no,pay_amount,name,description,pic,pay_status')
            ->equalTo('no', $orderNo)
            ->one();
        if (!$orderInfo) return $this->false('非法订单');
        if (!$orderInfo['order_no'] || $orderInfo['order_no'] != $orderNo) return $this->false('订单错误');
        if (!$orderInfo['order_pay_amount']) return $this->false('金额错误');
        if (!$orderInfo['order_name']) return $this->false('单名错误');
        if (!$orderInfo['order_description']) return $this->false('订单主体错误');
        if ($orderInfo['order_pay_status'] != PayStatus::UNPAY) return $this->false('PAY_FINISH');

        return $orderInfo;
        /*
        $orderInfo = array(
            'order_no' => '653423275957324',
            'order_pay_amount' => 0.01,
            'order_name' => '测试',
            'order_description' => '测试测试测试',
            'order_pic' => '',
        );
        return $orderInfo;
        */
    }

    /**
     * DirectPay 构造一个要请求的参数数组，无需改动
     * @param WxpayBean $bean
     * @param bool $withOrder
     * @return array|bool
     */
    private function getWxPayParameter(WxpayBean $bean, $withOrder = true)
    {
        if ($withOrder) {
            $orderInfo = $this->getOrderInfo($bean->getOrderNo());
            if (!$orderInfo) return $this->false($this->getFalseMsg());
        }
        // 检查配置
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
        if (empty($externalConfigKV)) {
            return $this->false('配置错误:' . $bean->getExternalConfig());
        }
        $thisConfig = $externalConfigKV['wxpay'];
        if (empty($thisConfig['appid'])) return $this->false('无效的' . $thisConfig['appid_label']);
        if (empty($thisConfig['mchid'])) return $this->false('无效的' . $thisConfig['mchid_label']);
        if (empty($thisConfig['key'])) return $this->false('无效的' . $thisConfig['key_label']);
        if (empty($thisConfig['appsecret'])) return $this->false('无效的' . $thisConfig['appsecret_label']);
        if (empty($thisConfig['ssl_cert_path'])) return $this->false('无效的' . $thisConfig['ssl_cert_label']);
        if (empty($thisConfig['ssl_key_path'])) return $this->false('无效的' . $thisConfig['ssl_key_label']);
        if (empty($thisConfig['ssl_ca_path'])) return $this->false('无效的' . $thisConfig['ssl_ca_label']);
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
        $defaultConfig = array(
            'now' => (string)$this->getNow(),
            'micronow' => $this->getMicroNow(),
            'host' => $this->getHost(),
            'ip' => $this->getClientIP(),
            "company_name" => $name,
            //=======【基本信息设置】=====================================
            /**
             * TODO: 修改这里配置为您自己申请的商户信息
             * 微信公众号信息配置
             * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
             * MCHID：商户号（必须配置，开户邮件中可查看）
             * KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
             * 设置地址：https://pay.weixin.qq.com/index.php/account/api_cert
             * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），
             * 获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN
             * @var string
             */
            "appid" => $thisConfig['appid'],
            "mchid" => $thisConfig['mchid'],
            "key" => $thisConfig['key'],
            "appsecret" => $thisConfig['appsecret'],
            //=======【证书路径设置】=====================================
            /**
             * TODO：设置商户证书路径
             * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
             * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
             * @var string path
             */

            "ssl_cert" => $thisConfig['ssl_cert_path'],
            "ssl_key" => $thisConfig['ssl_key_path'],
            "ssl_ca" => $thisConfig['ssl_ca_path'],
            //=======【curl代理设置】===================================
            /**
             * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
             * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
             * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
             * @var mixed unknown_type
             */
            "curl_proxy_host" => "0.0.0.0", //"10.152.18.220";
            "curl_proxy_port" => 0,         //8080;
            //=======【上报信息配置】===================================
            /**
             * TODO：接口调用上报等级，默认紧错误上报（注意：上报超时间为【1s】，上报无论成败【永不抛出异常】，
             * 不会影响接口调用流程），开启上报之后，方便微信监控请求调用的质量，建议至少
             * 开启错误上报。
             * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
             * @var int
             */
            "report_levenl" => 1,
            "notify_url" => $this->getHost() . '/external/wxpayNotify',
        );
        //=======【订单信息】===================================
        if ($withOrder) {
            $defaultConfig['order_no'] = $orderInfo['order_no']; //订单号
            $defaultConfig['total_fee'] = $orderInfo['order_pay_amount']; // 付款金额
            $defaultConfig['subject'] = $orderInfo['order_name']; // 订单名称
            $defaultConfig['body'] = $orderInfo['order_description']; // 订单描述
        }
        return $defaultConfig;
    }

    public function callback()
    {
        $bean = $this->getBean();
        if (!$bean->getCallbackData()) {
            return $this->notFount('not callback data');
        }
        try {
            $callbackData = (new WxPayDataBase())->FromXml($bean->getCallbackData());
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        if ($callbackData['attach'] !== 'hunzsig') {
            return $this->error('not hunzsig');
        }
        $outTradeInfo = $this->getOutTradeInfo($callbackData['out_trade_no']);
        if (!$outTradeInfo) {
            return $this->notFount($this->getFalseMsg());
        }
        $bean->setOrderNo($outTradeInfo['external_trade_token_order_no']);
        $bean->setExternalConfig($outTradeInfo['external_trade_token_config']);
        $default = $this->getWxPayParameter($bean);
        if (!$default) {
            return $this->error($this->getFalseMsg());
        }
        $this->log($outTradeInfo['external_trade_token_config'], $callbackData, array());
        // 微信验证
        try {
            WxPayResults::Init($bean->getCallbackData(), $default);
        } catch (\Exception $e) {
            $this->log($outTradeInfo['external_trade_token_config'], ['xml' => $bean->getCallbackData()], ['error' => $e->getMessage()]);
            return $this->error($e->getMessage());
        }
        //TODO 在这里处理业务逻辑，成功返回true 失败返回false
        if ($callbackData['return_code'] == 'SUCCESS' && $callbackData['result_code'] == 'SUCCESS') {
            if (!$this->checkOutTradeInfo($outTradeInfo)) {
                return $this->goon(null, $this->getFalseMsg());
            }
            $this->db()->beginTrans();
            try {
                // 写记录
                $this->db()->table('external_trade_token')
                    ->equalTo('out_trade_no', $callbackData['out_trade_no'])
                    ->update(array(
                        'callback' => $callbackData,
                        'is_pay' => IsSure::yes,
                        'pay_account' => $callbackData['openid'],
                        'pay_time' => $this->db()->now(),
                    ));
                // 写订单
                $callbackData['total_fee'] = $this->totalFeeNotify($callbackData['total_fee']);
                $OrderBean = (new OrderBean());
                $OrderBean->setPayType(PayType::WXPAY);
                $OrderBean->setNo($outTradeInfo['external_trade_token_order_no']);
                $OrderBean->setPayReturnData($callbackData);
                $OrderModel = (new OrderModel($this->getIO()));
                if (!$OrderModel->pay__($OrderBean)) {
                    throw new \Exception($OrderModel->getFalseMsg());
                }
            } catch (\Exception $e) {
                $this->db()->rollBackTrans();
                return $this->error($e->getMessage());
            }
            $this->db()->commitTrans();
            return $this->success();
        }
    }

    /**
     * native 扫码支付
     * @return array
     */
    public function native()
    {
        $bean = $this->getBean();
        if (!$bean->getExternalConfig()) return $this->error('not config');
        if (!$bean->getOrderNo()) return $this->error('not order no');
        $parameter = $this->getWxPayParameter($bean);
        if (!$parameter) {
            return $this->error($this->getFalseMsg());
        }
        // 创建一个马甲单
        $outTradeNo = $this->buildOutTradeNo('WXPN');
        try {
            $this->db()->table('external_trade_token')->insert(array(
                'create_time' => $this->db()->now(),
                'out_trade_no' => $outTradeNo,
                'order_no' => $parameter['order_no'],
                'type' => __CLASS__ . DIRECTORY_SEPARATOR . __FUNCTION__,
                'amount' => $parameter['total_fee'],
                'config' => $bean->getExternalConfig(),
                'config_actual' => $this->getActualConfig($bean->getExternalConfig()),
            ));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        //服务器异步通知页面路径
        $notify_url = $parameter['notify_url'];
        //订单名称
        $subject = $parameter['subject'];
        //必填
        //付款金额
        $totalFee = $parameter['total_fee'];
        //必填
        //订单描述
        $body = $parameter['body'];
        //订单附加值
        //TODO 此值暂时无用，可用于回调传值
        $input = (new WxPayUnifiedOrder());
        $input->setConfigs($parameter);
        $input->SetBody($body);
        $input->SetAttach('hunzsig');
        $input->SetOut_trade_no($outTradeNo);
        $input->SetTotal_fee($this->totalFeeQuery($totalFee));
        $input->SetTime_start(date("YmdHis", $this->getNow()));
        $input->SetTime_expire(date("YmdHis", 600 + $this->getNow()));
        $input->SetGoods_tag($subject);
        $input->SetNotify_url($notify_url);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($parameter['order_no']);
        try {
            $WxPayNativePay = (new WxPayNativePay());
            $WxPayNativePay->setConfigs($parameter);
            $result = $WxPayNativePay->GetPayUrl($input);
            $url = $result["code_url"];
            if ($url) {
                return $this->success($url);
            }
            throw new \Exception('生成支付二维码失败！');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * jsapi 支付
     * @return array
     * @throws \plugins\Wxpay\Core\WxPayException
     */
    public function jsapi()
    {
        $bean = $this->getBean();
        $order_no = $bean->getOrderNo();
        $return_url = $bean->getReturnUrl();
        $back_url = $bean->getBackUrl();
        $external_config = $bean->getExternalConfig();
        if (!$order_no) return $this->error('not order no');
        if (!$return_url) return $this->error('not return url');
        if (!$back_url) return $this->error('not back url');
        if (!$external_config) return $this->error('not external config');

        $parameter = $this->getWxPayParameter($bean);
        if (!$parameter) {
            return $this->error($this->getFalseMsg());
        }

        $open_id = null;
        $tools = new WxPayJsApiPay();
        $tools->setConfigs($parameter);
        // todo 根据数据参数，来判断下一步操作
        if (!$open_id) {
            $paramsStr = serialize(array(
                'client_id' => $this->getClientID(),
                'order_no' => $order_no,
                'return_url' => $return_url,
                'back_url' => $back_url,
                'external_config' => $external_config,
            ));
            $paramsStr = base64_encode($this->encrypto($paramsStr));
            $paramsStr = str_replace('+', '-', $paramsStr);
            $paramsStr = str_replace('/', '|', $paramsStr);
            $paramsStr = str_replace('=', '*', $paramsStr);
            $baseUrl = $this->getHost() . '/external/wxpayJsapi?jsapi_params=' . $paramsStr;
            $baseUrl = urlencode($baseUrl);
            $open_id = $tools->GetOpenid($baseUrl, $bean->getCode());
            if (strpos($open_id, 'Location') !== false) {
                return $this->goon($open_id);
            }
        }

        //-----------------------------------------------

        // TODO 创建一个马甲单
        $outTradeNo = $this->buildOutTradeNo('WXPJ');
        try {
            $this->db()->table('external_trade_token')->insert(array(
                'create_time' => $this->db()->now(),
                'out_trade_no' => $outTradeNo,
                'order_no' => $parameter['order_no'],
                'type' => __CLASS__ . DIRECTORY_SEPARATOR . __FUNCTION__,
                'amount' => $parameter['total_fee'],
                'config' => $bean->getExternalConfig(),
                'config_actual' => $this->getActualConfig($bean->getExternalConfig()),
                'params' => array(
                    'return_url' => $bean->getReturnUrl(),
                ),
            ));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

        // TODO 统一下单
        $input = new WxPayUnifiedOrder();
        $input->setConfigs($parameter);
        $input->SetBody($parameter['body']);
        $input->SetAttach('hunzsig');
        $input->SetOut_trade_no($outTradeNo);
        $input->SetTotal_fee($this->totalFeeQuery($parameter['total_fee']));
        $input->SetTime_start(date("YmdHis", $parameter['now']));
        $input->SetTime_expire(date("YmdHis", $parameter['now'] + 600));
        $input->SetGoods_tag($parameter['subject']);
        $input->SetNotify_url($parameter['notify_url']);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($open_id);

        $WxPayApi = (new WxPayApi());
        $WxPayApi->setConfigs($parameter);
        $order = $WxPayApi->unifiedOrder($input);
        $successData = array(
            'jsapi_params' => $tools->GetJsApiParameters($order),
            'edit_address' => $tools->GetEditAddressParameters(),
            'back_url' => $bean->getBackUrl(),
            'out_trade_no' => $outTradeNo,
            'order_no' => $parameter['order_no'],
            'total_fee' => $parameter['total_fee'],
            'subject' => $parameter['subject'],
            'body' => $parameter['body'],
        );
        return $this->success($successData);
    }

    /**
     * H5 支付
     * @return array
     * @throws \plugins\Wxpay\Core\WxPayException
     */
    public function h5()
    {
        $bean = $this->getBean();
        $order_no = $bean->getOrderNo();
        $return_url = $bean->getReturnUrl() ?? null;
        $external_config = $bean->getExternalConfig();
        if (!$order_no) return $this->error('not order no');
        if (!$external_config) return $this->error('not external config');

        $parameter = $this->getWxPayParameter($bean);
        if (!$parameter) {
            return $this->error($this->getFalseMsg());
        }
        // TODO 创建一个马甲单
        $outTradeNo = $this->buildOutTradeNo('WXPH');
        try {
            $this->db()->table('external_trade_token')->insert(array(
                'create_time' => $this->db()->now(),
                'out_trade_no' => $outTradeNo,
                'order_no' => $parameter['order_no'],
                'type' => __CLASS__ . DIRECTORY_SEPARATOR . __FUNCTION__,
                'amount' => $parameter['total_fee'],
                'config' => $bean->getExternalConfig(),
                'config_actual' => $this->getActualConfig($bean->getExternalConfig()),
                'params' => array(
                    'return_url' => $bean->getReturnUrl(),
                ),
            ));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

        // TODO 统一下单
        $input = new WxPayUnifiedOrder();
        $input->setConfigs($parameter);
        $input->SetBody($parameter['body']);
        $input->SetAttach('hunzsig');
        $input->SetOut_trade_no($outTradeNo);
        $input->SetTotal_fee($this->totalFeeQuery($parameter['total_fee']));
        $input->SetTime_start(date("YmdHis", $parameter['now']));
        $input->SetTime_expire(date("YmdHis", $parameter['now'] + 600));
        $input->SetGoods_tag($parameter['subject']);
        $input->SetNotify_url($parameter['notify_url']);
        $input->SetTrade_type("MWEB");

        $WxPayApi = (new WxPayApi());
        $WxPayApi->setConfigs($parameter);
        $order = $WxPayApi->unifiedOrder($input);
        $url = $order['mweb_url'];
        if ($return_url) {
            $url .= '&redirect_url=' . urlencode($return_url);
        }
        return $this->success($url);
    }

    /**
     * 企业付款
     * @return array
     */
    public function promotionTransfers()
    {
        $bean = $this->getBean();
        $openId = $bean->getOpenId();
        $uid = $bean->getUid();
        $external_config = $bean->getExternalConfig();
        $totalFee = round($bean->getAmount(), 2);
        $tradeDesc = $bean->getDescription();
        //付款金额
        if ($totalFee != $bean->getAmount()) return $this->error('金额最小单位为分（0.01元）');
        //if ($totalFee < 1.00) return $this->error('非法金额,最低为1元');
        //付款描述
        if (!$tradeDesc) return $this->error('缺少付款描述');
        //付款真实IP
        $spbillCreateIp = $this->getClientIP();
        if (!$spbillCreateIp) return $this->error('缺少付款IP');
        if (!$external_config) return $this->error('not external config');

        if (!$openId) {
            if (!$uid) return $this->error('not user id');
            else {
                $userWxOpenId = $this->db()->table('user')->field('wx_open_id')->equalTo('uid', $uid)->one();
                $userWxOpenId = $userWxOpenId['user_wx_open_id'] ?? null;
                if (!$userWxOpenId) return $this->error('not user wx info');
                $actualConfig = $this->getActualConfig($bean->getExternalConfig());
                $externalWxOpenId = $this->db()->table('external_wx_user_info')->field('open_id')
                    ->equalTo('config', $actualConfig)->in('open_id', $userWxOpenId)
                    ->one();
                $openId = $externalWxOpenId['external_wx_user_info_open_id'] ?? null;
                if (!$openId) return $this->error('not external wx info');
            }
        }
        $parameter = $this->getWxPayParameter($bean, false);
        if (!$parameter) {
            return $this->error($this->getFalseMsg());
        }

        $mch_appid = $parameter['appid'];
        $mchid = $parameter['mchid'];
        $sslcert = $parameter['ssl_cert'];
        $sslkey = $parameter['ssl_key'];
        $sslca = $parameter['ssl_ca'];

        $outTradeNo = $this->buildOutTradeNo('WXPPT');
        $insertData = array();
        $insertData['out_trade_no'] = $outTradeNo;
        $insertData['create_time'] = $this->db()->now();
        $insertData['uid'] = $bean->getUid();
        $insertData['open_id'] = $openId;
        $insertData['amount'] = $totalFee;
        $insertData['config'] = $bean->getExternalConfig();
        $insertData['config_actual'] = $this->getActualConfig($bean->getExternalConfig());
        $insertData['params'] = $bean->toArray();
        try {
            $this->db()->table('external_wxpay_promotion_transfers')->insert($insertData);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        // 商户账号appid mch_appid 是 wx8888888888888888 String 微信分配的账号ID（企业号corpid即为此appId）
        // 商户号 mchid 是 1900000109 String(32) 微信支付分配的商户号
        // 设备号 device_info 否 013467007045764 String(32) 微信支付分配的终端设备号
        // 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
        // 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 签名，详见签名算法
        // 商户订单号 partner_trade_no 是 10000098201411111234567890 String 商户订单号，需保持唯一性
        // (只能是字母或者数字，不能包含有符号)
        // 用户openid openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String 商户appid下，某用户的openid
        // 校验用户姓名选项 check_name 是 FORCE_CHECK String NO_CHECK：不校验真实姓名
        // FORCE_CHECK：强校验真实姓名
        // 收款用户姓名 re_user_name 可选 王小王 String 收款用户真实姓名。
        // 如果check_name设置为FORCE_CHECK，则必填用户真实姓名
        // 金额 amount 是 10099 int 企业付款金额，单位为分
        // 企业付款描述信息 desc 是 理赔 String 企业付款操作说明信息。必填。
        // Ip地址 spbill_create_ip 是 192.168.0.1 String(32) 调用接口的机器Ip地址
        try {
            $data = array(
                'mch_appid' => $mch_appid,
                'mchid' => $mchid,
                'device_info' => '',
                'nonce_str' => randChar(32),
                'partner_trade_no' => $outTradeNo,
                'openid' => $openId,
                'check_name' => 'NO_CHECK',
                're_user_name' => '',
                'amount' => $this->totalFeeQuery($totalFee),
                'desc' => $tradeDesc,
                'spbill_create_ip' => $spbillCreateIp,
            );
            $input = (new WxPayDataBase());
            $input->setConfigs($parameter);
            $input->SetValues($data);
            $input->SetSign();
            $xml = $input->ToXml();
            $result = curlPostSSL('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', $xml, $sslcert, $sslkey, $sslca, 10);
            if (!$result) {
                throw new \Exception('请求无回应或证书错误');
            }
            $result = $input->FromXml($result);
            if ($result['return_code'] == 'SUCCESS') {
                if ($result['result_code'] == 'FAIL') {
                    throw new \Exception($result['err_code_des']);
                }
                $this->db()->table('external_wxpay_promotion_transfers')
                    ->equalTo('out_trade_no', $outTradeNo)
                    ->update(array('callback' => $result));
            } else {
                throw new \Exception($result['err_code_des']);
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success();
    }

}