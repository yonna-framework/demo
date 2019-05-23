<?php

namespace app\middleware;

class neck extends abstractMiddleware
{
    public function test()
    {
        var_dump('before.demo');
    }

}