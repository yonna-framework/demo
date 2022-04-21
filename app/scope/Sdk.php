<?php

namespace App\Scope;

use Yonna\Database\DB;
use Yonna\Database\Driver\Crypto;
use Yonna\Database\Driver\Pdo\Where;
use App\Prism\SdkPrism;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class Sdk
 * @package App\Scope
 */
class Sdk extends AbstractScope
{

    const TABLE = 'sdk';

    const CRYPTO = ['AES-256-CBC', '356P7452', '5f12has8jnxcvf24'];

    /**
     * @param array $keys
     * @return mixed|string
     * @throws Exception\DatabaseException
     */
    public function _get(array $keys)
    {
        $res = DB::connect()->table(self::TABLE)->where(fn(Where $w) => $w->in('key', $keys))->multi();
        if (!$res) {
            return [];
        }
        $Crypto = new Crypto(...self::CRYPTO);
        $res2 = [];
        foreach ($res as $k => $v) {
            $res2[$v['sdk_key']] = $Crypto::decrypt($v['sdk_value']);
        }
        return $res2;
    }

    /**
     * @return mixed|string
     * @throws Exception\DatabaseException
     */
    public function get()
    {
        ArrayValidator::required($this->input(), ['keys'], function ($error) {
            Exception::throw($error);
        });
        return $this->_get($this->input('keys'));
    }

    /**
     * 获取详情
     * @return array
     * @throws Exception\DatabaseException
     */
    public function one(): array
    {
        ArrayValidator::required($this->input(), ['key'], function ($error) {
            Exception::throw($error);
        });
        return DB::connect()
            ->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('key', $this->input('key')))
            ->one();
    }

    /**
     * @return mixed
     * @throws Exception\DatabaseException
     */
    public function multi(): array
    {
        $prism = new SdkPrism($this->request());
        return DB::connect()
            ->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getKey() && $w->equalTo('key', $prism->getKey());
            })
            ->orderBy('key', 'asc')
            ->multi();
    }

    /**
     * @return false|int
     * @throws Exception\DatabaseException
     */
    public function update()
    {
        ArrayValidator::required($this->input(), ['key'], function ($error) {
            Exception::throw($error);
        });
        $value = $this->input('value');
        if ($value) {
            $Crypto = new Crypto(...self::CRYPTO);
            $value = $Crypto::encrypt($value);
        }
        $data = ['value' => $value];
        return DB::connect()
            ->table(self::TABLE)
            ->where(fn(Where $w) => $w->equalTo('key', $this->input('key')))
            ->update($data);
    }

}