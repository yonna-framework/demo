<?php
namespace External\Map;

class AliyunSmsType extends \Common\Map\AbstractMap
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
        $this->set(self::identity, '身份验证');
        $this->set(self::login, '登录确认');
        $this->set(self::login_exception, '登录异常');
        $this->set(self::register, '用户注册');
        $this->set(self::change_login_pwd, '修改登录密码');
        $this->set(self::change_pay_pwd, '修改支付密码');
        $this->set(self::change_info, '信息变更');
        $this->set(self::event, '活动确认');
        $this->set(self::bing_wx, '绑定微信');
    }

}