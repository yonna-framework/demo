<?php

namespace app\middleware;

class tail extends abstractMiddleware
{
    public function test()
    {
        var_dump('after.demo');
    }

}