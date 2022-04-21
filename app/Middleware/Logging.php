<?php

namespace App\Middleware;

use Yonna\IO\Request;
use Yonna\Middleware\Before;
use App\Scope\UserLogin;
use Yonna\Throwable\Exception;

class Logging extends Before
{

    /**
     * @return Request
     * @throws Exception\LogoutException
     * @throws Exception\ThrowException
     */
    public function handle(): Request
    {
        $isLogin = $this->scope(UserLogin::class, 'isLogging');
        if ($isLogin !== true) {
            Exception::logout('UN_LOGIN');
        }
        $request = $this->request();
        $request->setLoggingId($this->scope(UserLogin::class, 'getLoggingId'));
        return $request;
    }
}