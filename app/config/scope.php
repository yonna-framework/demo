<?php

use PhpureCore\Glue\Scope;

Scope::post('login', function ($request) {
    dump($request);
});

Scope::get('restful', \app\scope\data\express::class, 'get');
Scope::post('restful', \app\scope\data\express::class, 'post');
Scope::put('restful', \app\scope\data\express::class, 'put');
Scope::patch('restful', \app\scope\data\express::class, 'patch');
Scope::delete('restful', \app\scope\data\express::class, 'delete');

Scope
    ::get('test', \app\scope\data\express::class, 'getList')
    ->middleware(\app\middleware\neck::class, 'test')
    ->middleware(\app\middleware\tail::class, 'test', true);