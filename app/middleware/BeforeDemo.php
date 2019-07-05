<?php

namespace app\middleware;

use Yonna\Middleware\Before;

class BeforeDemo extends Before
{

    public function handle()
    {
        echo('before');
    }

}