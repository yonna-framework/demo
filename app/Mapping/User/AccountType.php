<?php
/**
 * 账号类型
 */

namespace App\Mapping\User;

use Yonna\Mapping\Mapping;

class AccountType extends Mapping
{
    const NAME = 'name';
    const PHONE = 'phone';
    const EMAIL = 'email';
    const WX_OPEN_ID = 'wx_open_id';
    const WX_UNION_ID = 'wx_union_id';


    public function __construct()
    {
        self::setLabel(self::NAME, '用户名');
        self::setLabel(self::PHONE, '手机');
        self::setLabel(self::EMAIL, '邮箱');
        self::setLabel(self::WX_OPEN_ID, '微信开放ID');
        self::setLabel(self::WX_UNION_ID, '微信关联ID');
    }
}