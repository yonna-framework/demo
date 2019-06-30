<?php

namespace app\middleware;

use Yonna\Scope\After;

class AfterDemo extends After
{
    public function handle($params)
    {
        // echo('after');
    }

}