<?php

namespace App\Scope;

use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use App\Prism\SdkWxmpUserPrism;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class SdkWxmpUser
 * @package App\Scope
 */
class SdkWxmpUser extends AbstractScope
{

    const TABLE = 'sdk_wxmp_user';

    /**
     * 获取详情
     * @return array
     * @throws Exception\DatabaseException
     * @throws Exception\ThrowException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['openid'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('openid', $this->input('openid')))
            ->one();
    }

    /**
     * @return false|int
     * @throws Exception\DatabaseException
     */
    public function save()
    {
        ArrayValidator::required($this->input(), ['openid'], function ($error) {
            Exception::throw($error);
        });
        $prism = new SdkWxmpUserPrism($this->request());
        $one = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('openid', $prism->getOpenid()))
            ->one();
        $data = [
            'openid' => $prism->getOpenid(),
            'unionid' => $prism->getUnionid() ?? '',
            'sex' => $prism->getSex() ?? '',
            'nickname' => $prism->getNickname() ?? '',
            'headimgurl' => $prism->getHeadimgurl() ?? '',
            'language' => $prism->getLanguage() ?? '',
            'city' => $prism->getCity() ?? '',
            'province' => $prism->getProvince() ?? '',
            'country' => $prism->getCountry() ?? '',
        ];
        if ($one) {
            return DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('openid', $prism->getOpenid()))
                ->update($data);
        } else {
            $data['open_id'] = $prism->getOpenid();
            return DB::connect()->table(self::TABLE)->insert($data);
        }
    }

}