<?php

namespace App\Scope;

use Yonna\Foundation\Curl;
use Yonna\Foundation\Str;
use Yonna\Database\DB;
use Yonna\Log\Log;
use App\Mapping\User\AccountType;
use App\Prism\SdkWxmpPrism;
use Yonna\Throwable\Exception;

/**
 * Class Wxmp
 * @package App\Scope
 */
class SdkWxmp extends AbstractScope
{

    private static array $conf = [];

    /**
     * 获取sdk配置
     * @return array|mixed
     * @throws Exception\ParamsException
     * @throws Exception\ThrowException
     */
    private function getConfig()
    {
        if (!self::$conf) {
            $conf = $this->scope(Sdk::class, 'get', ['keys' => ['wxmp_appid', 'wxmp_secret']]);
            if ($conf) {
                self::$conf = $conf;
            }
        }
        if (!self::$conf['wxmp_appid']) {
            Exception::params('Invalid wxmp_appid');
        }
        if (!self::$conf['wxmp_secret']) {
            Exception::params('Invalid wxmp_secret');
        }
        return self::$conf;
    }

    /**
     * 获取 SnsOauth2AccessToken
     * @param null $wxCode
     * @return array|bool|null
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     * @throws Exception\ThrowException
     */
    private function snsOauth2AccessToken($wxCode = null)
    {
        $config = $this->getConfig();
        $accessToken = DB::redis()->get('sdk::snsOauth2AccessToken::' . $this->request()->getClientId());
        if (!$accessToken && $wxCode) {
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$config['wxmp_appid']}";
            $url .= "&secret={$config['wxmp_secret']}";
            $url .= "&code={$wxCode}";
            $url .= "&grant_type=authorization_code";
            $accessToken = Curl::get($url, 5.00);
            $accessToken = json_decode($accessToken, true);
            if (!empty($accessToken['errcode'])) {
                Exception::throw($accessToken['errcode']);
            }
            DB::redis()->set(
                'sdk::snsOauth2AccessToken::' . $this->request()->getClientId(),
                $accessToken,
                $accessToken['expires_in'] - 100
            );
        }
        return $accessToken;
    }

    /**
     * 获取 userInfo
     * @param $openid
     * @param $access_token
     * @return array|bool|null
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     * @throws Exception\ThrowException
     */
    private function userInfo($openid, $access_token)
    {
        $wxUserInfo = DB::redis()->get("sdk::userInfo::{$openid}");
        if (!$wxUserInfo) {
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            $wxUserInfo = Curl::get($url, 5.00);
            $wxUserInfo = json_decode($wxUserInfo, true);
            if (isset($wxUserInfo['errcode'])) {
                if (strpos($wxUserInfo['errmsg'], 'access_token is invalid or not latest') !== false) {
                    DB::redis()->delete('sdk::snsOauth2AccessToken::' . $this->request()->getClientId(),);
                    return $this->userInfo($openid, $access_token); // retry
                } else {
                    Exception::throw($wxUserInfo['errcode']);
                }
            }
            DB::redis()->set("sdk::userInfo::{$openid}", $wxUserInfo, 600);
        }
        return $wxUserInfo;
    }

    /**
     * 登录记录
     * @param $openid
     * @return mixed
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     * @throws Exception\ThrowException
     */
    private function loginRecord($openid)
    {
        if (!$openid) {
            Exception::params('error');
        }
        $one = $this->scope(UserAccount::class, 'one', [
            'string' => $openid,
            'type' => AccountType::WX_OPEN_ID,
        ]);
        if ($one) {
            $user_id = $one['user_account_user_id'];
        } else {
            $user_id = $openid;
        }
        // 写日志
        $input = $this->input();
        $log = [
            'openid' => $openid,
            'user_id' => $user_id,
            'ip' => $this->request()->getIp(),
            'client_id' => $this->request()->getClientId(),
            'input' => $input,
        ];
        Log::db()->info($log, 'login-wxmp');
        // 设定client_id为登录状态
        $onlineKey = UserLogin::ONLINE_REDIS_KEY . $log['client_id'];
        $onlineId = DB::redis()->get($onlineKey);
        if (!empty($onlineId)) {
            DB::redis()->expire($onlineKey, UserLogin::ONLINE_KEEP_TIME);
        } else {
            DB::redis()->set($onlineKey, $user_id, UserLogin::ONLINE_KEEP_TIME);
        }
        return $log['user_id'];
    }

    /**
     * @return string
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     * @throws Exception\ThrowException
     */
    public function oauth()
    {
        $prism = new SdkWxmpPrism($this->request());
        $tokenAuth = $this->snsOauth2AccessToken($prism->getCode());
        if (!$tokenAuth) {
            $config = $this->getConfig();
            $url = $this->request()->getHost();
            $wxConf = array(
                'appid' => $config['wxmp_appid'],
                'redirect_uri' => urlencode($url),
                'response_type' => 'code',
                'scope' => 'snsapi_userinfo',
                'state' => $prism->getState() ?: Str::random(10),
            );
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$wxConf['appid']}";
            $url .= "&redirect_uri={$wxConf['redirect_uri']}";
            $url .= "&response_type={$wxConf['response_type']}";
            $url .= "&scope={$wxConf['scope']}";
            $url .= "&state={$wxConf['state']}";
            $url .= "#wechat_redirect";
            return $url;
        } else {
            // 获取snsapi_userinfo
            $access_token = $tokenAuth['access_token'];
            //$expires_in = $tokenAuth['expires_in'];
            //$refresh_token = $tokenAuth['refresh_token'];
            $openid = $tokenAuth['openid'];
            //$scope = $tokenAuth['scope'];
            $wxUserInfo = $this->userInfo($openid, $access_token);
            if ($wxUserInfo) {
                $wxUserInfo['openid'] = $openid;
                $this->scope(SdkWxmpUser::class, 'save', $wxUserInfo);
                $wxUserInfo['logging_id'] = $this->loginRecord($openid);
            }
            return $wxUserInfo;
        }

    }

}