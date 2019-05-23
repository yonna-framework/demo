<?php

namespace app\middleware;

class neck extends abstractMiddleware
{
    public function handle()
    {
        print_r($this->request());
    }

}