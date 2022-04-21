<?php

namespace App\Scope;

use App\Helper\Password;

use App\Mapping\Common\Boolean;
use App\Mapping\User\AccountType;
use App\Mapping\User\UserStatus;
use Throwable;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Log\Log;
use Yonna\Throwable\Exception;

/**
 * Class Login
 * @package App\Scope
 */
class UserLogin extends AbstractScope
{

    const ONLINE_KEEP_TIME = 86400;
    const ONLINE_REDIS_KEY = 'user:online:';

    /**
     * 登录记录
     * @param $userInfo
     * @return bool
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     */
    public function loginRecord($userInfo)
    {
        if (!$userInfo['user_id']) {
            Exception::params('登录记录参数不全');
        }
        // 写日志
        $input = $this->input();
        $input['password'] = '*';
        $log = [
            'user_id' => $userInfo['user_id'],
            'ip' => $this->request()->getIp(),
            'client_id' => $this->request()->getClientId(),
            'input' => $input,
        ];
        Log::db()->info($log, 'login');
        // 设定client_id为登录状态
        $onlineKey = self::ONLINE_REDIS_KEY . $log['client_id'];
        $onlineId = DB::redis()->get($onlineKey);
        if (!empty($onlineId)) {
            DB::redis()->expire($onlineKey, self::ONLINE_KEEP_TIME);
        } else {
            DB::redis()->set($onlineKey, $log['user_id'], self::ONLINE_KEEP_TIME);
        }
        return true;
    }

    /**
     * @return mixed
     * @throws null
     */
    public function getLoggingId()
    {
        if (!$this->request()->getClientId()) {
            return 0;
        }
        return DB::redis()->get(self::ONLINE_REDIS_KEY . $this->request()->getClientId()) ?? 0;
    }

    /**
     * @return bool
     * @throws null
     */
    public function isLogging(): bool
    {
        $loggingId = $this->getLoggingId();
        return !empty($loggingId);
    }

    /**
     * logout
     * @return mixed
     * @throws Throwable
     */
    public function out()
    {
        if ($this->request()->getClientId()) {
            DB::redis()->delete(self::ONLINE_REDIS_KEY . $this->request()->getClientId());
        }
        return true;
    }

    /**
     * @return mixed
     * @throws Throwable
     */
    public function in()
    {
        $account = $this->input('account');
        $password = $this->input('password');
        if (!$account) {
            Exception::params("error account");
        }
        if (!$password) {
            Exception::params("error password");
        }
        // 看看账号是否存在
        $accounts = DB::connect()
            ->table('user_account')
            ->field('user_id')
            ->where(function (Where $cond) use ($account) {
                $cond->in('type', [AccountType::NAME, AccountType::PHONE, AccountType::EMAIL])
                    ->equalTo('string', $account)
                    ->equalTo('allow_login', Boolean::true);
            })
            ->one();
        if (empty($accounts['user_account_user_id'])) {
            Exception::params("Account does not exist");
        }
        $user_id = $accounts['user_account_user_id'];
        $userInfo = DB::connect()
            ->table('user')
            ->field('id,status,password')
            ->where(fn(Where $w) => $w->equalTo('id', $user_id))
            ->one();
        // 检查账号状态
        switch ($userInfo['user_status']) {
            case UserStatus::DELETE:
                Exception::error('Account is not exist');
                break;
            case UserStatus::FREEZE:
                Exception::error('Account has been frozen');
                break;
            case UserStatus::PENDING:
                Exception::error('Account has not been approved, please wait for approval');
                break;
            case UserStatus::REJECTION:
                Exception::error('Account audit failed');
                break;
            default:
                break;
        }
        // 检查许可
        $userLicense = DB::connect()
            ->table('user_license')
            ->field('license_id')
            ->where(function (Where $w) use ($user_id) {
                $w
                    ->equalTo('user_id', $user_id)
                    ->lessThanOrEqualTo('start_datetime', date('Y-m-d H:i:s', time()))
                    ->greaterThanOrEqualTo('end_datetime', date('Y-m-d H:i:s', time()));
            })
            ->multi();
        if (!$userLicense) {
            Exception::error("Account not any licensed");
        }
        $userLicenseIds = array_column($userLicense, 'user_license_license_id');
        // 额外的自定义检查
        $checkLicenseId = $this->input('license_id');
        if ($checkLicenseId) {
            if (!is_array($checkLicenseId)) {
                $checkLicenseId = [$checkLicenseId];
            }
            $inCheck = false;
            foreach ($checkLicenseId as $lid) {
                $lid = (int)$lid;
                if (in_array($lid, $userLicenseIds)) {
                    $inCheck = true;
                    break;
                }
            }
            if (!$inCheck) {
                Exception::error("Account not licensed");
            }
        }
        $al = DB::connect()->table('license')
            ->field('allow_scope')
            ->where(fn(Where $w) => $w->in('id', $userLicenseIds))
            ->multi();
        $allowScopes = [];
        foreach ($al as $l) {
            foreach ($l['license_allow_scope'] as $s) {
                $s = strtoupper($s);
                $allowScopes[] = $s;
            }
        }
        $allowScopes = array_unique($allowScopes);
        $currentScope = strtoupper($this->input('scope'));
        if (!in_array('ALL', $allowScopes) && !in_array($currentScope, $allowScopes)) {
            //Exception::error("Account not licensed");
        }
        // 检查密码
        if (empty($userInfo['user_password']) || $userInfo['user_password'] !== Password::parse($password)) {
            Exception::error('Wrong password');
        }
        // 记录登录信息
        try {
            $this->loginRecord($userInfo);
        } catch (Throwable $e) {
            Exception::origin($e);
        }
        return [
            'user_id' => $user_id,
            'user_account' => $account,
            'user_status' => $userInfo['user_status'],
        ];
    }

}