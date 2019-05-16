<?php
/**
 * 银行帐号帐号类型
 * Created by PhpStorm.
 * User: hunzsig
 * Date: 2015/12/04
 * Time: 18:23
 */

namespace Finance\Map;


class BankAccountType extends \Common\Map\AbstractMap{

    const ACCOUNT_PUBLIC = '1';
    const ACCOUNT_PRIVATE = '2';
    const ACCOUNT_SELF_SAVINGS_DEPOSIT_CARD = '3';
    const ACCOUNT_SELF_CREDIT_CARD = '4';
    const ACCOUNT_THIRD = '5';

    public function __construct(){

        $this->set(self::ACCOUNT_SELF_SAVINGS_DEPOSIT_CARD ,    '个人储蓄卡');
        $this->set(self::ACCOUNT_SELF_CREDIT_CARD ,             '个人信用卡');
        $this->set(self::ACCOUNT_THIRD ,                        '第三方理财账号');
        $this->set(self::ACCOUNT_PUBLIC ,                       '对公帐号');
        $this->set(self::ACCOUNT_PRIVATE ,                      '对私帐号');

    }

}