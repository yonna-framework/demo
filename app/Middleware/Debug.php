<?php

namespace App\Middleware;

use Yonna\IO\Request;
use Yonna\Middleware\Before;
use Yonna\Throwable\Exception;

class Debug extends Before
{
    /**
     * @return Request
     * @throws Exception\ErrorException
     */
    public function handle(): Request
    {
        if (getenv('DEBUG') === 'false') {
            Exception::error('NOT_DEBUG');
        }
        return $this->request();
    }

}