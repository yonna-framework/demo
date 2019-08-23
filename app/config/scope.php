<?php

use app\middleware\AfterDemo;
use app\middleware\BeforeDemo;
use app\scope\data\Express;
use Yonna\Scope\Config;

Config::post('login', function ($request) {
    dump($request);
});

Config::get('restful', Express::class, 'get');
Config::post('restful', Express::class, 'post');
Config::put('restful', Express::class, 'put');
Config::patch('restful', Express::class, 'delete');

Config::middleware(
    [
        BeforeDemo::class,
        AfterDemo::class,
    ],
    function () {

        Config::post('express', Express::class, 'getList');
        Config::get('express', Express::class, 'getList');

    }
);