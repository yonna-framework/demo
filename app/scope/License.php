<?php

namespace App\Scope;

use Throwable;
use Yonna\Foundation\Arr;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use App\Prism\LicensePrism;
use Yonna\Scope\Config as ScopeConfig;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class License
 * @package App\Scope
 */
class License extends AbstractScope
{

    const TABLE = 'license';

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
            ->one();
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function tree(): array
    {
        $res = DB::connect()->table(self::TABLE)->orderBy('upper_id', 'asc')->multi();
        return Arr::tree($res, 0, 'license_id', 'license_upper_id');
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function scopes(): array
    {
        $id = $this->input('id');
        $scopes = [];
        if ($id) {
            $res = DB::connect()->table(self::TABLE)
                ->field('allow_scope')
                ->where(fn(Where $w) => $w->equalTo('id', $id))
                ->one();
            $scopes = $res['license_allow_scope'];
            if (in_array('all', $scopes)) {
                $scopes = [];
                $sc = ScopeConfig::fetch();
                foreach ($sc as $k => $v) {
                    foreach ($v as $kk => $vv) {
                        $scopes[] = "{$k}.{$kk}";
                    }
                }
            }
        } else {
            $sc = ScopeConfig::fetch();
            foreach ($sc as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $scopes[] = "{$k}.{$kk}";
                }
            }
        }
        sort($scopes);
        return $scopes;
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['name', 'upper_id'], function ($error) {
            Exception::throw($error);
        });
        $upper = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('id', $this->input('upper_id')))
            ->one();
        if (!$upper) {
            Exception::params('The upper level does not exist');
        }
        $same = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('name', $this->input('name')))
            ->one();
        if ($same) {
            Exception::params('Name already exists');
        }
        $add = [
            'name' => $this->input('name'),
            'upper_id' => $this->input('upper_id'),
            'allow_scope' => $this->input('allow_scope') ?? [],
        ];
        return DB::connect()->table(self::TABLE)->insert($add);
    }

    /**
     * @return bool|int
     * @throws Exception\DatabaseException
     * @throws Exception\ParamsException
     */
    public function update()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        if ($this->input('name')) {
            $same = DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('name', $this->input('name')))
                ->one();
            if ($same && $same['license_id'] !== $this->input('id')) {
                Exception::params('Name already exists');
            }
        }
        $data = [
            'name' => $this->input('name'),
            'allow_scope' => $this->input('allow_scope'),
        ];
        if ($data) {
            return DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('id', $this->input('id')))
                ->update($data);
        }
        return true;
    }

    /**
     * @return int
     * @throws Throwable
     */
    public function delete()
    {
        ArrayValidator::required($this->input(), ['id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new LicensePrism($this->request());
        return DB::transTrace(function () use ($prism) {
            $count = $this->scope(UserLicense::class, 'count', ['license_id' => $prism->getId()]);
            if ($count > 0) {
                if ($prism->isForce() !== true) {
                    Exception::params('In use and cannot be deleted');
                }
                $this->scope(UserLicense::class, 'delete', ['license_id' => $prism->getId()]);
            }
            return DB::connect()->table(self::TABLE)
                ->where(fn(Where $w) => $w->equalTo('id', $prism->getId()))
                ->delete();
        });
    }

}