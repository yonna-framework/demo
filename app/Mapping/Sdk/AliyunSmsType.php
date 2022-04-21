<?php

namespace App\Mapping\Sdk;

use Yonna\Mapping\Mapping;

class AliyunSmsType extends Mapping
{

    const identity = 'identity';
    const login = 'login';
    const login_exception = 'login_exception';
    const register = 'register';
    const change_login_pwd = 'change_login_pwd';
    const change_pay_pwd = 'change_pay_pwd';
    const change_info = 'change_info';
    const event = 'event';
    const bing_wx = 'bing_wx';

    public function __construct()
    {
        self::setLabel(self::identity, '身份验证');
        self::setLabel(self::login, '登录确认');
        self::setLabel(self::login_exception, '登录异常');
        self::setLabel(self::register, '用户注册');
        self::setLabel(self::change_login_pwd, '修改登录密码');
        self::setLabel(self::change_pay_pwd, '修改支付密码');
        self::setLabel(self::change_info, '信息变更');
        self::setLabel(self::event, '活动确认');
        self::setLabel(self::bing_wx, '绑定微信');
    }

}