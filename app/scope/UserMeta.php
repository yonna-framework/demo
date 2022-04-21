<?php

namespace App\Scope;

use Throwable;
use Yonna\Foundation\Arr;
use App\Mapping\Common\Boolean;
use App\Prism\UserMetaPrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class Meta
 * @package App\Scope\User
 */
class UserMeta extends AbstractScope
{

    const TABLE = 'user_meta';

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['user_id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new UserMetaPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $w->equalTo('user_id', $prism->getUserId());
                $prism->getKey() && $w->equalTo('key', $prism->getKey());
            })
            ->one();
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function multi(): array
    {
        $prism = new UserMetaPrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
                $prism->getKey() && $w->equalTo('key', $prism->getKey());
            })
            ->multi();
    }

    /**
     * @return bool
     * @throws Throwable
     */
    public function cover()
    {
        ArrayValidator::required($this->input(), ['user_id', 'metas'], function ($error) {
            Exception::throw($error);
        });
        $user_id = $this->input('user_id');
        $metas = $this->input('metas');
        $add = [];
        foreach ($metas as $k => $v) {
            if (!empty($v)) {
                $add[] = [
                    'user_id' => $user_id,
                    'key' => $k,
                    'value' => $v,
                ];
            }
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
     * @throws Exception\ThrowException
     * @throws Exception\DatabaseException
     */
    public function attach(): array
    {
        $prism = new UserMetaPrism($this->request());
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
        $category = $this->scope(UserMetaCategory::class, 'multi', ['status' => Boolean::true]);
        $values = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->in('user_id', $ids))
            ->multi();
        $meta = [];
        foreach ($values as $v) {
            if (!isset($meta[$v['user_meta_user_id']])) {
                $meta[$v['user_meta_user_id']] = [];
            }
            $meta[$v['user_meta_user_id']][$v['user_meta_key']] = $v['user_meta_value'];
        }
        unset($values);
        foreach ($category as $c) {
            $key = $c['user_meta_category_key'];
            foreach ($tmp as $uk => $u) {
                if (!empty($meta[$u['user_id']]) && isset($meta[$u['user_id']][$key])) {
                    $val = $meta[$u['user_id']][$key];
                } else {
                    $val = $c['user_meta_category_value_default'];
                }
                $tmp[$uk]['user_meta_' . $key] = UserMetaCategory::valueFormat($val, $c['user_meta_category_value_format']);
            }
        }
        if ($isPage) {
            $data['list'] = $tmp;
            return $data;
        }
        return $isOne ? $tmp[0] : $tmp;
    }

}