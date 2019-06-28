<?php

use app\middleware\AfterDemo;
use app\middleware\BeforeDemo;
use app\scope\data\Express;
use PhpureCore\Glue\Scope;

Scope::post('login', function ($request) {
    dump($request);
});

Scope::get('restful', Express::class, 'get');
Scope::post('restful', Express::class, 'post');
Scope::put('restful', Express::class, 'put');
Scope::patch('restful', Express::class, 'delete');

Scope::middleware(
    [
        BeforeDemo::class,
        AfterDemo::class,
    ],
    function () {

        Scope::get('express', Express::class, 'getList');

    }
);