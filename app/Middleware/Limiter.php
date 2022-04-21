<?php

namespace App\Middleware;

use Yonna\Database\DB;
use Yonna\IO\Request;
use Yonna\Middleware\Before;
use Yonna\Throwable\Exception;

class Limiter extends Before
{

    const REDIS_KEY = 'limiter:';
    const TIMEOUT = 3;
    const LIMIT = 100;

    /**
     * IP N秒内请求限制器
     * @return Request
     * @throws Exception\DatabaseException
     * @throws Exception\ThrowException
     */
    public function handle(): Request
    {
        $ip = $this->request()->getIp();
        $k = self::REDIS_KEY . $ip;
        $limit = DB::redis()->gcr($k);
        DB::redis()->incr($k);
        if ($limit > self::LIMIT) {
            DB::redis()->expire($k, $limit * 2);
            Exception::throw('OVER LIMIT');
        }
        DB::redis()->expire($k, self::TIMEOUT);
        return $this->request();
    }

}