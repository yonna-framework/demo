<?php

namespace app\middleware;

use PhpureCore\Scope\Middleware;

class Before extends Middleware
{

    public function handle($params)
    {
        // echo('before');
    }

}