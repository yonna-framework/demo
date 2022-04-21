<?php

namespace App\Scope;

use App\Prism\UserLicensePrism;
use Yonna\Database\DB;
use Yonna\Database\Driver\Pdo\Where;
use Yonna\Throwable\Exception;
use Yonna\Validator\ArrayValidator;

/**
 * Class License
 * @package App\Scope
 */
class UserLicense extends AbstractScope
{

    const TABLE = 'user_license';

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
    public function multi(): array
    {
        $prism = new UserLicensePrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
                $prism->getLicenseId() && $w->equalTo('license_id', $prism->getLicenseId());
                $prism->getStartTime() && $w->greaterThanOrEqualTo('start_time', $prism->getStartTime());
                $prism->getEndTime() && $w->lessThanOrEqualTo('end_time', $prism->getEndTime());
            })
            ->multi();
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function count(): int
    {
        $prism = new UserLicensePrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
                $prism->getLicenseId() && $w->equalTo('license_id', $prism->getLicenseId());
                $prism->getStartTime() && $w->greaterThanOrEqualTo('start_time', $prism->getStartTime());
                $prism->getEndTime() && $w->lessThanOrEqualTo('end_time', $prism->getEndTime());
            })
            ->count();
    }

    /**
     * @return bool
     * @throws Exception\DatabaseException
     */
    public function insert()
    {
        ArrayValidator::required($this->input(), ['user_id', 'license_id'], function ($error) {
            Exception::throw($error);
        });
        $user_id = $this->input('user_id');
        $license_id = $this->input('license_id');
        $one = DB::connect()->table(self::TABLE)
            ->where(fn(Where $w) => $w
                ->equalTo('user_id', $user_id)
                ->equalTo('license_id', $license_id)
            )
            ->one();
        if ($one) {
            return true;
        }
        $add = [
            'user_id' => $user_id,
            'license_id' => $license_id,
        ];
        DB::connect()->table(self::TABLE)->insert($add);
        return true;
    }

    /**
     * @return int
     * @throws Exception\DatabaseException
     */
    public function delete()
    {
        ArrayValidator::anyone($this->input(), ['user_id', 'license_id'], function ($error) {
            Exception::throw($error);
        });
        $prism = new UserLicensePrism($this->request());
        return DB::connect()->table(self::TABLE)
            ->where(function (Where $w) use ($prism) {
                $prism->getUserId() && $w->equalTo('user_id', $prism->getUserId());
                $prism->getLicenseId() && $w->equalTo('license_id', $prism->getLicenseId());
            })
            ->delete();
    }

    /**
     * @return bool
     * @throws \Throwable
     */
    public function cover()
    {
        ArrayValidator::required($this->input(), ['user_id', 'licenses'], function ($error) {
            Exception::throw($error);
        });
        $user_id = $this->input('user_id');
        $licenses = $this->input('licenses');
        $add = [];
        foreach ($licenses as $license_id) {
            $add[] = [
                'user_id' => $user_id,
                'license_id' => $license_id,
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

}
