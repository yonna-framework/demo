<?php

namespace app\middleware;

use PhpureCore\Scope\Before;

class BeforeDemo extends Before
{

    public function handle($params)
    {
        // echo('before');
    }

}