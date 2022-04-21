<?php

namespace App\Scope;

use Yonna\Database\DB;
use Yonna\Foundation\Str;
use Yonna\Log\Log;
use App\Helper\Assets;
use App\Mapping\User\AccountType;
use App\Mapping\User\UserStatus;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class UserWechat
 * @package App\Scope
 */
class UserWechat extends AbstractScope
{

    /**
     * @return mixed
     * @throws Exception\ThrowException
     */
    public function bind()
    {
        ArrayValidator::required($this->input(), ['phone'], function ($error) {
            Exception::throw($error);
        });
        $openid = $this->request()->getLoggingId();
        if (!is_string($openid)) {
            Exception::throw('openid error');
        }
        $checkOpenId = $this->scope(UserAccount::class, 'one', ['string' => $openid]);
        if ($checkOpenId) {
            Exception::throw('openid already bind');
        }
        $sdk = $this->scope(SdkWxmpUser::class, 'one', ['openid' => $openid]);
        if (!$sdk) {
            Exception::throw('wechat user is not authenticated');
        }
        $phone = $this->input('phone');
        $metas = $this->input('metas');
        $licenses = $this->input('licenses');
        // 合并一下从微信获得的数据，如果用户有自定义则跳过
        if (empty($metas['sex']) && !empty($sdk['sdk_wxmp_user_sex'])) {
            $metas['sex'] = (int)$sdk['sdk_wxmp_user_sex'];
        }
        if (empty($metas['name']) && !empty($sdk['sdk_wxmp_user_nickname'])) {
            $metas['name'] = $sdk['sdk_wxmp_user_nickname'];
        }
        if (empty($metas['avatar']) && !empty($sdk['sdk_wxmp_user_headimgurl'])) {
            $src = Assets::getUrlSource($sdk['sdk_wxmp_user_headimgurl']);
            if ($src) {
                $res = (new Xoss($this->request()))->saveFile($src);
                if ($res) {
                    $metas['avatar'] = $res['xoss_key'];
                }
            }
        }
        if (!is_array($metas['avatar'])) {
            $metas['avatar'] = [$metas['avatar']];
        }
        $user_id = DB::transTrace(function () use ($phone, $openid, $metas, $licenses) {
            $find = $this->scope(UserAccount::class, 'one', ['string' => $phone]);
            $user_id = $find['user_account_user_id'] ?? null;
            // 有数据则绑定原有账号，没数据则新建账号
            if ($user_id) {
                // 更新数据
                $data = [
                    'id' => $user_id,
                    'metas' => $metas,
                ];
                $this->scope(User::class, 'update', $data);
                // 许可判定
                if ($licenses) {
                    foreach ($licenses as $l) {
                        $this->scope(UserLicense::class, 'insert', [
                            'user_id' => $user_id,
                            'license_id' => $l,
                        ]);
                    }
                }
            } else {
                $data = [
                    'password' => Str::randomLetter(10),
                    'accounts' => [$phone => AccountType::PHONE],
                    'licenses' => $licenses,
                    'metas' => $metas,
                    'status' => UserStatus::APPROVED,
                ];
                $user_id = $this->scope(User::class, 'insert', $data);
            }
            // 记录openid
            $this->scope(UserAccount::class, 'insert', [
                'user_id' => $user_id,
                'string' => $openid,
                'type' => AccountType::WX_OPEN_ID,
            ]);
            return $user_id;
        });
        // 写日志
        $input = $this->input();
        $log = [
            'user_id' => $user_id,
            'ip' => $this->request()->getIp(),
            'client_id' => $this->request()->getClientId(),
            'input' => $input,
        ];
        Log::db()->info($log, 'login-bind');
        // 设定client_id为登录状态
        $onlineKey = UserLogin::ONLINE_REDIS_KEY . $log['client_id'];
        $onlineId = DB::redis()->get($onlineKey);
        $onlineId = (int)$onlineId;
        if ($onlineId > 0) {
            DB::redis()->expire($onlineKey, UserLogin::ONLINE_KEEP_TIME);
        } else {
            DB::redis()->set($onlineKey, $user_id, UserLogin::ONLINE_KEEP_TIME);
        }
        return $this->scope(User::class, 'one', ['id' => $user_id]);
    }


}