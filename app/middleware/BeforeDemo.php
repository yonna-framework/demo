<?php

namespace app\middleware;

use Yonna\Scope\Before;

class BeforeDemo extends Before
{

    public function handle($params)
    {
        // echo('before');
    }

}