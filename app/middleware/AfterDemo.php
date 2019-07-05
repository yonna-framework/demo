<?php

namespace app\middleware;

use Yonna\Middleware\After;

class AfterDemo extends After
{
    public function handle()
    {
        echo('after');
    }

}