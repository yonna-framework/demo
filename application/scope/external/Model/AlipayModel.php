<?php

namespace External\Model;

use Common\Map\IsSure;
use Order\Bean\OrderBean;
use Order\Map\PayStatus;
use External\Bean\AlipayBean;
use Order\Map\PayType;
use Order\Model\OrderModel;

class AlipayModel extends AbstractModel
{

    /**
     * @return AlipayBean
     */
    protected function getBean()
    {
        return parent::getBean();
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
     * @param AlipayBean $bean
     * @return array|bool
     */
    private function getDirectPayParameter(AlipayBean $bean)
    {
        $orderInfo = $this->getOrderInfo($bean->getOrderNo());
        if (!$orderInfo) return $this->false($this->getFalseMsg());
        // 检查配置
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
        if (empty($externalConfigKV)) {
            return $this->false('配置错误:' . $bean->getExternalConfig());
        }
        $thisConfig = $externalConfigKV['alipay_direct_pay'];
        if (empty($thisConfig['partner'])) return $this->false('无效的' . $thisConfig['partner_label']);
        if (empty($thisConfig['seller_email'])) return $this->false('无效的' . $thisConfig['seller_email_label']);
        if (empty($thisConfig['32_key'])) return $this->false('无效的' . $thisConfig['32_key_label']);
        if (empty($thisConfig['cacert_path'])) return $this->false('无效的' . $thisConfig['cacert_label']);
        $defaultConfig = array(
            'payment_type' => "1", // 支付类型【必填，不能修改】
            'partner' => $thisConfig['partner'], // 合作身份者id，以2088开头的16位纯数字
            'seller_email' => $thisConfig['seller_email'], // 收款支付宝账号
            'key' => $thisConfig['32_key'], // 安全检验码，以数字和字母组成的32位字符
            //'cacert' => $thisConfig['cacert_path'], // ca证书路径地址，用于curl中ssl校验 请保证cacert.pem文件在目标文件夹目录中
            'cacert' => $thisConfig['cacert_path'],
            'exter_invoke_ip' => $this->getClientIP() != '127.0.0.1' ? $this->getClientIP() : '119.29.149.227', // 客户端的IP地址 非局域网的外网IP地址
            'sign_type' => strtoupper('MD5'), // 签名方式 不需修改
            'input_charset' => trim(strtolower('utf-8')), // 字符编码格式 目前支持 gbk 或 utf-8
            'transport' => $this->isSSL() ? 'https' : 'http', // 访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
            'notify_url' => $this->getHost() . '/external/alipayDirectPayNotify', // 服务器异步通知页面路径【需http://格式的完整路径，不能加?id=>123这类自定义参数】
            'return_url' => $this->getHost() . '/external/alipayDirectPayReturn', // 页面跳转同步通知页面路径【需http://格式的完整路径，不能加?id=>123这类自定义参数，不能写成http://localhost/】
            //
            'service' => 'create_direct_pay_by_user',
            'anti_phishing_key' => '', //防钓鱼时间戳 若要使用请调用类文件submit中的query_timestamp函数
            //
            'order_no' => $orderInfo['order_no'], //订单号
            'total_fee' => $orderInfo['order_pay_amount'], // 付款金额
            'subject' => $orderInfo['order_name'], // 订单名称
            'body' => $orderInfo['order_description'], // 订单描述
            'show_url' => $orderInfo['order_pic'] ?? '', // 商品展示地址 需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        );
        return $defaultConfig;
    }

    /**
     * WapV1 构造一个要请求的参数数组，无需改动
     * @param AlipayBean $bean
     * @return array|bool
     */
    private function getWapV1Parameter(AlipayBean $bean)
    {
        $orderInfo = $this->getOrderInfo($bean->getOrderNo());
        if (!$orderInfo) return $this->false($this->getFalseMsg());
        // 检查配置
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
        if (empty($externalConfigKV)) {
            return $this->false('配置错误:' . $bean->getExternalConfig());
        }
        $thisConfig = $externalConfigKV['alipay_wap_v1'];
        if (!$thisConfig['partner']) return $this->false('无效的' . $thisConfig['partner_label']);
        if (!$thisConfig['seller_id']) return $this->false('无效的' . $thisConfig['seller_id_label']);
        if (!$thisConfig['cacert_path']) return $this->false('无效的' . $thisConfig['cacert_label']);
        if (!$thisConfig['private_key_path']) return $this->false('无效的' . $thisConfig['private_key_label']);
        if (!$thisConfig['ali_public_key_path']) return $this->false('无效的' . $thisConfig['ali_public_key_label']);
        $defaultConfig = array(
            'payment_type' => "1", //支付类型【必填，不能修改】
            'partner' => $thisConfig['partner'], // 合作身份者id，以2088开头的16位纯数字
            'seller_id' => $thisConfig['seller_id'], //收款支付宝账号
            'cacert' => $thisConfig['cacert_path'], //ca证书路径地址
            'private_key_path' => $thisConfig['private_key_path'], //商户的私钥（后缀是.pen）文件路径
            'ali_public_key_path' => $thisConfig['ali_public_key_path'], //支付宝公钥（后缀是.pen）文件相对路径
            'sign_type' => strtoupper('RSA'), //签名方式 不需修改
            'input_charset' => strtolower('utf-8'), //字符编码格式 目前支持 gbk 或 utf-8
            'transport' => $this->isSSL() ? 'https' : 'http',
            'notify_url' => $this->getHost() . '/external/alipayWapV1Notify', // 服务器异步通知页面路径【需http://格式的完整路径，不能加?id=>123这类自定义参数】
            'return_url' => $this->getHost() . '/external/alipayWapV1Return', // 页面跳转同步通知页面路径【需http://格式的完整路径，不能加?id=>123这类自定义参数，不能写成http://localhost/】
            //
            'service' => 'alipay.wap.create.direct.pay.by.user',
            'it_b_pay' => '10m',
            'extern_token' => '',
            //
            'order_no' => $orderInfo['order_no'], //订单号
            'total_fee' => $orderInfo['order_pay_amount'], // 付款金额
            'subject' => $orderInfo['order_name'], // 订单名称
            'body' => $orderInfo['order_description'], // 订单描述
            'show_url' => $orderInfo['order_pic'] ?? '', // 商品展示地址 需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        );
        return $defaultConfig;
    }

    /**
     * WapV2 构造一个要请求的参数数组，无需改动
     * @param AlipayBean $bean
     * @return array|bool
     */
    private function getWapV2Parameter(AlipayBean $bean)
    {
        $orderInfo = $this->getOrderInfo($bean->getOrderNo());
        if (!$orderInfo) return $this->false($this->getFalseMsg());
        // 检查配置
        $externalConfigKV = $this->getExternalKV($bean->getExternalConfig(), true);
        if (empty($externalConfigKV)) {
            return $this->false('配置错误:' . $bean->getExternalConfig());
        }
        $thisConfig = $externalConfigKV['alipay_wap_v2'];
        if (!$thisConfig['app_id']) return $this->false('无效的' . $thisConfig['app_id_label']);
        if (!$thisConfig['private_key']) return $this->false('无效的' . $thisConfig['private_key_label']);
        if (!$thisConfig['public_key']) return $this->false('无效的' . $thisConfig['public_key_label']);
        if (!$thisConfig['ali_public_key']) return $this->false('无效的' . $thisConfig['ali_public_key_label']);
        if (!$thisConfig['aes_encrypt_key']) return $this->false('无效的' . $thisConfig['aes_encrypt_key_label']);
        $defaultConfig = array(
            'app_id' => $thisConfig['app_id'],
            'private_key' => $thisConfig['private_key'], // 商户的私钥
            'public_key' => $thisConfig['public_key'], // 商户的公钥
            'ali_public_key' => $thisConfig['ali_public_key'], // 支付宝公钥
            'encrypt_key' => $thisConfig['aes_encrypt_key'], // AES密钥
            'sign_type' => strtoupper('RSA'), //签名方式 不需修改
            'input_charset' => strtolower('utf-8'), //字符编码格式 目前支持 gbk 或 utf-8
            'transport' => $this->isSSL() ? 'https' : 'http',
            'notify_url' => $this->getHost() . '/external/alipayWapV2Notify', // 服务器异步通知页面路径【需http://格式的完整路径，不能加?id=>123这类自定义参数】
            'return_url' => $this->getHost() . '/external/alipayWapV2Return', // 页面跳转同步通知页面路径【需http://格式的完整路径，不能加?id=>123这类自定义参数，不能写成http://localhost/】
            //
            'gateway_url' => "https://openapi.alipay.com/gateway.do",
            'it_b_pay' => '10m', // 超时时间
            //
            'order_no' => $orderInfo['order_no'], //订单号
            'total_fee' => $orderInfo['order_pay_amount'], // 付款金额
            'subject' => $orderInfo['order_name'], // 订单名称
            'body' => $orderInfo['order_description'], // 订单描述
        );
        return $defaultConfig;
    }


    /**
     * 即时支付
     * @return array
     */
    public function directPay()
    {
        $bean = $this->getBean();
        if (!$bean->getExternalConfig()) return $this->error('not config');
        if (!$bean->getOrderNo()) return $this->error('not order no');
        if (!$bean->getReturnUrl()) return $this->error('not return url');
        if (!$bean->getBackUrl()) return $this->error('not back url');
        $default = $this->getDirectPayParameter($bean);
        if (!$default) {
            return $this->error($this->getFalseMsg());
        }
        // 创建一个马甲单
        $outTradeNo = $this->buildOutTradeNo('ALPD');
        try {
            $this->db()->table('external_trade_token')->insert(array(
                'create_time' => $this->db()->now(),
                'out_trade_no' => $outTradeNo,
                'order_no' => $default['order_no'],
                'type' => __CLASS__ . DIRECTORY_SEPARATOR . __FUNCTION__,
                'amount' => $default['total_fee'],
                'config' => $bean->getExternalConfig(),
                'config_actual' => $this->getActualConfig($bean->getExternalConfig()),
                'params' => array(
                    'return_url' => $bean->getReturnUrl(),
                    'back_url' => $bean->getBackUrl(),
                ),
            ));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        $config = array(
            'payment_type' => $default['payment_type'],
            'partner' => $default['partner'],
            'seller_email' => $default['seller_email'],
            'key' => $default['key'],
            'exter_invoke_ip' => $default['exter_invoke_ip'],
            'sign_type' => $default['sign_type'],
            'input_charset' => $default['input_charset'],
            'cacert' => $default['cacert'],
            'transport' => $default['transport'],
            'notify_url' => $default['notify_url'],
            'return_url' => $default['return_url'],
        );
        $parameter = array(
            "service" => $default['service'],
            "partner" => $default['partner'],
            "seller_email" => $default['seller_email'],
            "payment_type" => $default['payment_type'],
            "notify_url" => $default['notify_url'],
            "return_url" => $default['return_url'],
            "out_trade_no" => $outTradeNo,
            "subject" => $default['subject'],
            "total_fee" => $default['total_fee'],
            "body" => $default['body'],
            "show_url" => $default['show_url'],
            "anti_phishing_key" => $default['anti_phishing_key'],
            "exter_invoke_ip" => $default['exter_invoke_ip'],
            "_input_charset" => $default['input_charset'],
        );
        $alipaySubmit = (new \plugins\Alipay\DirectPay\AlipaySubmit());
        $alipaySubmit->setConfig($config);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        return $this->success($html_text);
    }

    public function directPayCallBack()
    {
        $bean = $this->getBean();
        if (!$bean->getCallbackData()) {
            return $this->notFount('not callback data');
        }
        $callbackData = $bean->getCallbackData();
        $outTradeInfo = $this->getOutTradeInfo($callbackData['out_trade_no']);
        if (!$outTradeInfo) {
            return $this->notFount($this->getFalseMsg());
        }
        $return_url = $outTradeInfo['external_trade_token_params']['return_url'] ?? null;
        $back_url = $outTradeInfo['external_trade_token_params']['back_url'] ?? null;
        if (!$return_url) return $this->notFount('not return url');
        if (!$back_url) return $this->notFount('not back url');
        $orderInfo = $this->getOrderInfo($outTradeInfo['external_trade_token_order_no']);
        $resultArray = $orderInfo;
        $resultArray['return_url'] = $return_url;
        $resultArray['back_url'] = $back_url;
        if (!$orderInfo) {
            if ($this->getFalseMsg() === 'PAY_FINISH') {
                return $this->goon($resultArray, '已完成支付');
            }
            return $this->error($this->getFalseMsg(), $resultArray);
        }
        if (empty($orderInfo['order_pay_amount']) || empty($callbackData['total_fee']) || $orderInfo['order_pay_amount'] != $callbackData['total_fee']) {
            return $this->error('金额非法', $resultArray);
        }
        if (!$this->checkOutTradeInfo($outTradeInfo)) {
            return $this->goon($resultArray, $this->getFalseMsg());
        }
        $bean->setOrderNo($outTradeInfo['external_trade_token_order_no']);
        $bean->setExternalConfig($outTradeInfo['external_trade_token_config']);
        $default = $this->getDirectPayParameter($bean);
        if (!$default) {
            return $this->error($this->getFalseMsg(), $resultArray);
        }
        $config = array(
            'payment_type' => $default['payment_type'],
            'partner' => $default['partner'],
            'seller_email' => $default['seller_email'],
            'key' => $default['key'],
            'exter_invoke_ip' => $default['exter_invoke_ip'],
            'sign_type' => $default['sign_type'],
            'input_charset' => $default['input_charset'],
            'cacert' => $default['cacert'],
            'transport' => $default['transport'],
            'notify_url' => $default['notify_url'],
            'return_url' => $default['return_url'],
        );
        $alipayNotify = (new \plugins\Alipay\DirectPay\AlipayNotify());
        $alipayNotify->setConfig($config);
        $verify_result = $alipayNotify->verifyNotify($callbackData);
        // 写日志
        $this->log($outTradeInfo['external_trade_token_config'], $callbackData, array_merge(['verify_result' => $verify_result], $outTradeInfo));
        if ($verify_result) {
            if ($callbackData['trade_status'] == 'TRADE_SUCCESS') {
                $this->db()->beginTrans();
                try {
                    // 写记录
                    $this->db()->table('external_trade_token')
                        ->equalTo('out_trade_no', $callbackData['out_trade_no'])
                        ->update(array(
                            'callback' => $callbackData,
                            'is_pay' => IsSure::yes,
                            'pay_account' => implode('|', [$callbackData['buyer_email'], $callbackData['buyer_id']]),
                            'pay_time' => $this->db()->now(),
                        ));
                    // 写订单
                    $callbackData['total_fee'] = round($callbackData['total_fee'], 10);
                    $OrderBean = (new OrderBean());
                    $OrderBean->setPayType(PayType::ALIPAY);
                    $OrderBean->setNo($outTradeInfo['external_trade_token_order_no']);
                    $OrderBean->setPayReturnData($callbackData);
                    $OrderModel = (new OrderModel($this->getIO()));
                    if (!$OrderModel->pay__($OrderBean)) {
                        throw new \Exception($OrderModel->getFalseMsg());
                    }
                } catch (\Exception $e) {
                    $this->db()->rollBackTrans();
                    if ($e->getMessage() === 'PAY_FINISH') {
                        return $this->goon('已完成支付', $resultArray);
                    }
                    return $this->error($e->getMessage(), $resultArray);
                }
                $this->db()->commitTrans();
            }
        } else {
            try {
                $this->db()->table('external_trade_token')
                    ->equalTo('out_trade_no', $callbackData['out_trade_no'])
                    ->update(array('callback' => $callbackData));
            } catch (\Exception $e) {
            }
            return $this->error('验证失败', $resultArray);
        }
        return $this->success($resultArray);
    }


    /**
     * wap v1
     * @return array
     */
    public function wapV1()
    {
        $bean = $this->getBean();
        if (!$bean->getExternalConfig()) return $this->error('not config');
        if (!$bean->getOrderNo()) return $this->error('not order no');
        if (!$bean->getReturnUrl()) return $this->error('not return url');
        if (!$bean->getBackUrl()) return $this->error('not back url');
        $default = $this->getWapV1Parameter($bean);
        if (!$default) {
            return $this->error($this->getFalseMsg());
        }
        // 创建一个马甲单
        $outTradeNo = $this->buildOutTradeNo('ALWI');
        try {
            $this->db()->table('external_trade_token')->insert(array(
                'create_time' => $this->db()->now(),
                'out_trade_no' => $outTradeNo,
                'order_no' => $default['order_no'],
                'type' => __CLASS__ . DIRECTORY_SEPARATOR . __FUNCTION__,
                'amount' => $default['total_fee'],
                'config' => $bean->getExternalConfig(),
                'config_actual' => $this->getActualConfig($bean->getExternalConfig()),
                'params' => array(
                    'return_url' => $bean->getReturnUrl(),
                    'back_url' => $bean->getBackUrl(),
                ),
            ));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        $config = array(
            'payment_type' => $default['payment_type'],
            'partner' => $default['partner'],
            'seller_id' => $default['seller_id'],
            'private_key_path' => $default['private_key_path'],
            'ali_public_key_path' => $default['ali_public_key_path'],
            'sign_type' => $default['sign_type'],
            'input_charset' => $default['input_charset'],
            'cacert' => $default['cacert'],
            'transport' => $default['transport'],
            'notify_url' => $default['notify_url'],
            'return_url' => $default['return_url'],
        );
        $parameter = array(
            "service" => $default['service'],
            "partner" => $default['partner'],
            "seller_id" => $default['seller_id'],
            "payment_type" => $default['payment_type'],
            "notify_url" => $default['notify_url'],
            "return_url" => $default['return_url'],
            "out_trade_no" => $outTradeNo,
            "subject" => $default['subject'],
            "total_fee" => $default['total_fee'],
            "body" => $default['body'],
            "show_url" => $default['show_url'],
            "it_b_pay" => $default['it_b_pay'],
            "extern_token" => $default['extern_token'],
            "_input_charset" => $default['input_charset'],
        );
        $alipaySubmit = (new \plugins\Alipay\WapV1\AlipaySubmit());
        $alipaySubmit->setConfig($config);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        return $this->success($html_text);
    }

    public function wapV1CallBack()
    {
        $bean = $this->getBean();
        if (!$bean->getCallbackData()) {
            return $this->notFount('not callback data');
        }
        $callbackData = $bean->getCallbackData();
        $outTradeInfo = $this->getOutTradeInfo($callbackData['out_trade_no']);
        if (!$outTradeInfo) {
            return $this->notFount($this->getFalseMsg());
        }
        $return_url = $outTradeInfo['external_trade_token_params']['return_url'] ?? null;
        $back_url = $outTradeInfo['external_trade_token_params']['back_url'] ?? null;
        if (!$return_url) return $this->notFount('not return url');
        if (!$back_url) return $this->notFount('not back url');
        $orderInfo = $this->getOrderInfo($outTradeInfo['external_trade_token_order_no']);
        $resultArray = $orderInfo;
        $resultArray['return_url'] = $return_url;
        $resultArray['back_url'] = $back_url;
        if (!$orderInfo) {
            if ($this->getFalseMsg() === 'PAY_FINISH') {
                return $this->goon('已完成支付', $resultArray);
            }
            return $this->error($this->getFalseMsg(), $resultArray);
        }
        if (empty($orderInfo['order_pay_amount'])
            || empty($callbackData['total_fee'])
            || $orderInfo['order_pay_amount'] != $callbackData['total_fee']) {
            return $this->error('金额非法', $resultArray);
        }
        if (!$this->checkOutTradeInfo($outTradeInfo)) {
            return $this->goon($resultArray, $this->getFalseMsg());
        }
        $bean->setOrderNo($outTradeInfo['external_trade_token_order_no']);
        $bean->setExternalConfig($outTradeInfo['external_trade_token_config']);
        $default = $this->getWapV1Parameter($bean);
        if (!$default) {
            return $this->error($this->getFalseMsg(), $resultArray);
        }
        $config = array(
            'payment_type' => $default['payment_type'],
            'partner' => $default['partner'],
            'seller_id' => $default['seller_id'],
            'private_key_path' => $default['private_key_path'],
            'ali_public_key_path' => $default['ali_public_key_path'],
            'sign_type' => $default['sign_type'],
            'input_charset' => $default['input_charset'],
            'cacert' => $default['cacert'],
            'transport' => $default['transport'],
            'notify_url' => $default['notify_url'],
            'return_url' => $default['return_url'],
        );
        $alipayNotify = (new \plugins\Alipay\WapV1\AlipayNotify());
        $alipayNotify->setConfig($config);
        $verify_result = $alipayNotify->verifyNotify($callbackData);
        // 写日志
        $this->log($outTradeInfo['external_trade_token_config'], $callbackData, array_merge(['verify_result' => $verify_result], $outTradeInfo));
        if ($verify_result) {
            if ($callbackData['trade_status'] == 'TRADE_SUCCESS') {
                $this->db()->beginTrans();
                try {
                    // 写记录
                    $this->db()->table('external_trade_token')
                        ->equalTo('out_trade_no', $callbackData['out_trade_no'])
                        ->update(array(
                            'callback' => $callbackData,
                            'is_pay' => IsSure::yes,
                            'pay_time' => $this->db()->now(),
                        ));
                    // 写订单
                    $callbackData['total_fee'] = round($callbackData['total_fee'], 10);
                    $OrderBean = (new OrderBean());
                    $OrderBean->setPayType(PayType::ALIPAY);
                    $OrderBean->setNo($outTradeInfo['external_trade_token_order_no']);
                    $OrderBean->setPayReturnData($callbackData);
                    $OrderModel = (new OrderModel($this->getIO()));
                    if (!$OrderModel->pay__($OrderBean)) {
                        throw new \Exception($OrderModel->getFalseMsg());
                    }
                } catch (\Exception $e) {
                    $this->db()->rollBackTrans();
                    if ($e->getMessage() === 'PAY_FINISH') {
                        return $this->goon('已完成支付', $resultArray);
                    }
                    return $this->error($e->getMessage(), $resultArray);
                }
                $this->db()->commitTrans();
            }
        } else {
            try {
                $this->db()->table('external_trade_token')
                    ->equalTo('out_trade_no', $callbackData['out_trade_no'])
                    ->update(array('callback' => $callbackData));
            } catch (\Exception $e) {
            }
            return $this->error('验证失败', $resultArray);
        }
        return $this->success($resultArray);
    }


    /**
     * wap v2
     * @return array
     */
    public function wapV2()
    {
        $bean = $this->getBean();
        if (!$bean->getExternalConfig()) return $this->error('not config');
        if (!$bean->getOrderNo()) return $this->error('not order no');
        if (!$bean->getReturnUrl()) return $this->error('not return url');
        if (!$bean->getBackUrl()) return $this->error('not back url');
        $default = $this->getWapV2Parameter($bean);
        if (!$default) {
            return $this->error($this->getFalseMsg());
        }
        // 创建一个马甲单
        $outTradeNo = $this->buildOutTradeNo('ALWII');
        try {
            $this->db()->table('external_trade_token')->insert(array(
                'create_time' => $this->db()->now(),
                'out_trade_no' => $outTradeNo,
                'order_no' => $default['order_no'],
                'type' => __CLASS__ . DIRECTORY_SEPARATOR . __FUNCTION__,
                'amount' => $default['total_fee'],
                'config' => $bean->getExternalConfig(),
                'config_actual' => $this->getActualConfig($bean->getExternalConfig()),
                'params' => array(
                    'return_url' => $bean->getReturnUrl(),
                    'back_url' => $bean->getBackUrl(),
                ),
            ));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        $parameter = array(
            'app_id' => $default['app_id'],
            'merchant_private_key' => $default['private_key'],
            "notify_url" => $default['notify_url'],
            "return_url" => $default['return_url'],
            'charset' => $default['input_charset'],
            'sign_type' => $default['sign_type'],
            'gatewayUrl' => $default['gateway_url'],
            'alipay_public_key' => $default['ali_public_key'],
            'encrypt_key' => $default['encrypt_key'],
        );
        $payRequestBuilder = (new \plugins\Alipay\WapV2\Buildermodel\AlipayTradeWapPayContentBuilder());
        $payRequestBuilder->setBody($default['body']);
        $payRequestBuilder->setSubject($default['subject']);
        $payRequestBuilder->setOutTradeNo($outTradeNo);
        $payRequestBuilder->setTotalAmount($default['total_fee']);
        $payRequestBuilder->setTimeExpress($default['it_b_pay']);
        try {
            $payResponse = (new \plugins\Alipay\WapV2\AlipayTradeService($parameter));
            $html_txt = $payResponse->wapPay($payRequestBuilder, $parameter['return_url'], $parameter['notify_url']);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success($html_txt);
    }

    public function wapV2CallBack()
    {
        $bean = $this->getBean();
        if (!$bean->getCallbackData()) {
            return $this->notFount('not callback data');
        }
        $callbackData = $bean->getCallbackData();
        $outTradeInfo = $this->getOutTradeInfo($callbackData['out_trade_no']);
        if (!$outTradeInfo) {
            return $this->notFount($this->getFalseMsg());
        }
        $return_url = $outTradeInfo['external_trade_token_params']['return_url'] ?? null;
        $back_url = $outTradeInfo['external_trade_token_params']['back_url'] ?? null;
        if (!$return_url) return $this->notFount('not return url');
        if (!$back_url) return $this->notFount('not back url');
        $orderInfo = $this->getOrderInfo($outTradeInfo['external_trade_token_order_no']);
        $resultArray = $orderInfo;
        $resultArray['return_url'] = $return_url;
        $resultArray['back_url'] = $back_url;
        if (!$orderInfo) {
            if ($this->getFalseMsg() === 'PAY_FINISH') {
                return $this->goon('已完成支付', $resultArray);
            }
            return $this->error($this->getFalseMsg(), $resultArray);
        }
        if (empty($orderInfo['order_pay_amount'])
            || empty($callbackData['total_amount'])
            || $orderInfo['order_pay_amount'] != $callbackData['total_amount']) {
            return $this->error('金额非法', $resultArray);
        }
        if (!$this->checkOutTradeInfo($outTradeInfo)) {
            return $this->goon($resultArray, $this->getFalseMsg());
        }
        $bean->setOrderNo($outTradeInfo['external_trade_token_order_no']);
        $bean->setExternalConfig($outTradeInfo['external_trade_token_config']);
        $default = $this->getWapV2Parameter($bean);
        if (!$default) {
            return $this->error($this->getFalseMsg(), $resultArray);
        }
        $config = array(
            'app_id' => $default['app_id'],
            'private_key' => $default['private_key'],
            'public_key' => $default['public_key'],
            'ali_public_key' => $default['ali_public_key'],
            'encrypt_key' => $default['encrypt_key'],
            'merchant_private_key' => $default['private_key'],
            'gatewayUrl' => $default['gateway_url'],
            'alipay_public_key' => $default['ali_public_key'],
            'sign_type' => $default['sign_type'],
            'charset' => $default['input_charset'],
            'transport' => $default['transport'],
            'it_b_pay' => $default['it_b_pay'],
            'notify_url' => $default['notify_url'],
            'return_url' => $default['return_url'],
        );
        try {
            $payResponse = (new \plugins\Alipay\WapV2\AlipayTradeService($config));
            $verify_result = $payResponse->check($callbackData);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        // 写日志
        $this->log($outTradeInfo['external_trade_token_config'], $callbackData, array_merge(['verify_result' => $verify_result], $outTradeInfo));
        if ($verify_result) {
            $this->db()->beginTrans();
            try {
                // 写记录
                $this->db()->table('external_trade_token')
                    ->equalTo('out_trade_no', $callbackData['out_trade_no'])
                    ->update(array(
                        'callback' => $callbackData,
                        'is_pay' => IsSure::yes,
                        'pay_time' => $this->db()->now(),
                    ));
                // 写订单
                $callbackData['total_fee'] = round($callbackData['total_fee'], 10);
                $OrderBean = (new OrderBean());
                $OrderBean->setPayType(PayType::ALIPAY);
                $OrderBean->setNo($outTradeInfo['external_trade_token_order_no']);
                $OrderBean->setPayReturnData($callbackData);
                $OrderModel = (new OrderModel($this->getIO()));
                if (!$OrderModel->pay__($OrderBean)) {
                    throw new \Exception($OrderModel->getFalseMsg());
                }
            } catch (\Exception $e) {
                $this->db()->rollBackTrans();
                if ($e->getMessage() === 'PAY_FINISH') {
                    return $this->goon('已完成支付', $resultArray);
                }
                return $this->error($e->getMessage(), $resultArray);
            }
            $this->db()->commitTrans();
        }
        return $this->success($resultArray);
    }

}