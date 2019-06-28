<?php

namespace app\middleware;

use PhpureCore\Scope\After;

class AfterDemo extends After
{
    public function handle($params)
    {
        // echo('after');
    }

}