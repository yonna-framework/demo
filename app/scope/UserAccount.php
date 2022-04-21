<?php

namespace App\Scope;

use Yonna\Foundation\Arr;
use App\Mapping\Common\Boolean;
use App\Mapping\User\AccountType;
use App\Prism\UserAccountPrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class Meta
 * @package App\Scope\User
 */
class UserAccount extends AbstractScope
{

    const TABLE = 'user_account';

    /**
     * 获取详情
     * @return array
     * @throws Exception\DatabaseException
     */
    public function one(): array
    {
        ArrayValidator::anyone($this->input(), ['id', 'string'], function ($error) {
            Exception::throw($error);
        });
        $prism = new UserAccountPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getId() && $w->equalTo('id', $prism->getId());
                $prism->getString() && $w->equalTo('string', $prism->getString());
                $prism->getType() && $w->equalTo('type', $prism->getType());
            })
            ->one();
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
        $id = $this->input('id');
        $string = $this->input('string');
        if ($string) {
            $one = DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('string', $string))
                ->one();
            if ($one && $one['user_account_id'] !== $id) {
                Exception::params('Account already used');
            }
        }
        $edit = [
            'type' => $this->input('type'),
            'string' => $string,
            'allow_login' => $this->input('allow_login'),
        ];
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $id))
            ->update($edit);
    }

    /**
     * @return bool
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     * @throws \Throwable
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['user_id', 'string', 'type'], function ($error) {
            Exception::throw($error);
        });
        $user_id = $this->input('user_id');
        $account = $this->input('string');
        $type = $this->input('type');
        if (!in_array($type, AccountType::toArray())) {
            Exception::throw('type error');
        }
        $acc = DB::connect()->table(self::TABLE)->where(fn(Where $w) => $w->equalTo('string', $account))->one();
        if ($acc) {
            Exception::params('Account already exists');
        }
        $allow_login = Boolean::false;
        if (in_array($type, [AccountType::PHONE, AccountType::EMAIL, AccountType::NAME])) {
            $allow_login = Boolean::true;
        }
        $add = [
            'user_id' => $user_id,
            'type' => $type,
            'string' => $account,
            'allow_login' => $this->input('allow_login') ?? $allow_login,
        ];
        return DB::connect()->table(self::TABLE)->insert($add);
    }

    /**
     * @return bool
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     * @throws \Throwable
     */
    public function insertAll()
    {
        ArrayValidator::required($this->input(), ['user_id', 'accounts'], function ($error) {
            Exception::throw($error);
        });
        $user_id = $this->input('user_id');
        $accounts = $this->input('accounts');
        $accKeys = array_keys($accounts);
        $accCount = DB::connect()->table(self::TABLE)->where(fn(Where $w) => $w->in('string', $accKeys))->count();
        if ($accCount > 0) {
            Exception::params('Account already exists');
        }
        $add = [];
        foreach ($accounts as $account => $type) {
            $allow_login = Boolean::false;
            if (in_array($type, [AccountType::PHONE, AccountType::EMAIL, AccountType::NAME])) {
                $allow_login = Boolean::true;
            }
            $add[] = [
                'user_id' => $user_id,
                'type' => $type,
                'string' => $account,
                'allow_login' => $allow_login,
            ];
        }
        DB::transTrace(function () use ($user_id, $add) {
            DB::connect()->table(self::TABLE)->where(fn(Where $w) => $w->equalTo('user_id', $user_id))->delete();
            if ($add) {
                DB::connect()->table(self::TABLE)->insertAll($add);
            }
        });
        return true;
    }

    /**
     * @return array
     * @throws Exception\DatabaseException
     */
    public function attach(): array
    {
        $prism = new UserAccountPrism($this->request());
        $data = $prism->getAttach();
        $isPage = isset($data['page']);
        $isOne = Arr::isAssoc($data);
        if ($isPage) {
            $tmp = $data['list'];
        } elseif ($isOne) {
            $tmp = [$data];
        } else {
            $tmp = $data;
        }
        if (!$tmp) {
            return [];
        }
        $ids = array_column($tmp, 'user_id');
        $values = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('user_id', $ids))
            ->multi();
        $accounts = [];
        foreach ($values as $v) {
            if (!isset($accounts[$v['user_account_user_id']])) {
                $accounts[$v['user_account_user_id']] = [];
            }
            $accounts[$v['user_account_user_id']][] = $v;
        }
        unset($values);
        foreach ($tmp as $uk => $u) {
            $tmp[$uk]['user_account'] = empty($accounts[$u['user_id']]) ? [] : $accounts[$u['user_id']];
        }
        if ($isPage) {
            $data['list'] = $tmp;
            return $data;
        }
        return $isOne ? $tmp[0] : $tmp;
    }

}