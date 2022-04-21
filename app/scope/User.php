<?php

namespace App\Scope;

use App\Helper\Password;
use App\Mapping\User\UserStatus;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use App\Prism\UserPrism;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

class User extends AbstractScope
{

    const TABLE = 'user';

    /**
     * 获取详情
     * @return array
     * @throws Exception\DatabaseException
     * @throws Exception\ThrowException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $result = DB::connect()->table(self::TABLE)->field('id,status,inviter_user_id,register_time')
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->one();
        $result = $this->scope(UserMeta::class, 'attach', ['attach' => $result]);
        $result = $this->scope(UserAccount::class, 'attach', ['attach' => $result]);
        return $result;
    }

    /**
     * 获取列表
     * @return array
     * @throws Exception\DatabaseException
     */
    public function multi(): array
    {
        $prism = new UserPrism($this->request());
        $db = DB::connect()
            ->table(self::TABLE)
            ->field('id,status,inviter_user_id,register_time')
            ->where(function (Where $w) use ($prism) {
                $w->notEqualTo('status', UserStatus::DELETE);
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getIds() && $w->in('id', $prism->getIds());
                $prism->getInviterUserId() && $w->equalTo('inviter_user_id', $prism->getInviterUserId());
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
                $prism->getRegisterTime() && $w->between('register_time', $prism->getRegisterTime());
            });
        if ($prism->getOrderBy()) {
            $db->orderByStr($prism->getOrderBy());
        } else {
            $db->orderBy('id', 'desc', 'user');
        }
        $list = $db->multi() ?? [];
        $list = $this->scope(UserMeta::class, 'attach', ['attach' => $list]);
        $list = $this->scope(UserAccount::class, 'attach', ['attach' => $list]);
        return $list;
    }

    /**
     * 获取分页列表
     * @return array
     * @throws Exception\DatabaseException
     */
    public function page(): array
    {
        $prism = new UserPrism($this->request());
        $db = DB::connect()
            ->table(self::TABLE)
            ->field('id,status,inviter_user_id,register_time')
            ->where(function (Where $w) use ($prism) {
                $w->notEqualTo('status', UserStatus::DELETE);
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getIds() && $w->in('id', $prism->getIds());
                $prism->getInviterUserId() && $w->equalTo('inviter_user_id', $prism->getInviterUserId());
                $prism->getStatus() && $w->equalTo('status', $prism->getStatus());
                $prism->getRegisterTime() && $w->between('register_time', $prism->getRegisterTime());
            });
        if ($prism->getLicenseId()) {
            $db->join(self::TABLE, 'user_license', ['id' => 'user_id'])
                ->groupBy('id', 'user')
                ->where(fn(Where $w) => $w->searchTable('user_license')->equalTo('license_id', $prism->getLicenseId()));
        }
        if ($prism->getAccount()) {
            $db->join(self::TABLE, 'user_account', ['id' => 'user_id'])
                ->groupBy('id', 'user')
                ->where(fn(Where $w) => $w->searchTable('user_account')->like('string', "%" . $prism->getAccount() . "%"));
        }
        if ($prism->getOrderBy()) {
            $db->orderByStr($prism->getOrderBy());
        } else {
            $db->orderBy('id', 'desc', 'user');
        }
        $page = $db->page($prism->getCurrent(), $prism->getPer());
        $page = $this->scope(UserMeta::class, 'attach', ['attach' => $page]);
        $page = $this->scope(UserAccount::class, 'attach', ['attach' => $page]);
        return $page;
    }

    /**
     * @return mixed|null
     * @throws Exception\ParamsException
     * @throws \Throwable
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['password', 'accounts'], function ($error) {
            Exception::throw($error);
        });
        $pwd = $this->input('password');
        if (!Password::check($pwd)) {
            Exception::params(Password::getFalseMsg());
        }
        $pwd = Password::parse($pwd);
        $add = [
            'password' => $pwd,
            'status' => $this->input('status') ?? UserStatus::PENDING,
            'inviter_user_id' => $this->input('inviter_user_id') ?? 0,
            'register_time' => time(),
        ];
        $accounts = $this->input('accounts');
        $licenses = $this->input('licenses');
        $metas = $this->input('metas');
        return DB::transTrace(function () use ($add, $accounts, $licenses, $metas) {
            $user_id = DB::connect()->table(self::TABLE)->insert($add);
            $this->scope(UserAccount::class, 'insertAll', [
                'user_id' => $user_id,
                'accounts' => $accounts,
            ]);
            if ($licenses) {
                $this->scope(UserLicense::class, 'cover', [
                    'user_id' => $user_id,
                    'licenses' => $licenses,
                ]);
            }
            if ($metas) {
                $this->scope(UserMeta::class, 'cover', [
                    'user_id' => $user_id,
                    'metas' => $metas,
                ]);
            }
            return $user_id;
        });
    }

    /**
     * @return false|int
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     */
    public function update()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $pwd = $this->input('password');
        if ($pwd) {
            if (!Password::check($pwd)) {
                Exception::params(Password::getFalseMsg());
            }
            $pwd = Password::parse($pwd);
        }
        $edit = [
            'status' => $this->input('status'),
            'inviter_user_id' => $this->input('inviter_user_id'),
        ];
        if ($pwd) {
            $edit['password'] = $pwd;
        }
        $user_id = $this->input('id');
        $metas = $this->input('metas');
        DB::transTrace(function () use ($user_id, $edit, $metas) {
            DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('id', $user_id))
                ->update($edit);
            if ($metas) {
                $this->scope(UserMeta::class, 'cover', [
                    'user_id' => $user_id,
                    'metas' => $metas,
                ]);
            }
        });
        return true;
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function delete(): int
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->update(["status" => UserStatus::DELETE]);
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function multiStatus(): int
    {
        ArrayValidator::required($this->input(), ['ids', 'status'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('id', $this->input('ids')))
            ->update(["status" => $this->input('status')]);
    }

}