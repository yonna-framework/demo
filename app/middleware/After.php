<?php

namespace app\middleware;

use PhpureCore\Scope\Middleware;

class After extends Middleware
{
    public function handle($params)
    {
        // echo('after');
    }

}