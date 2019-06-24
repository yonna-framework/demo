<?php

use PhpureCore\Glue\Scope;

Scope::post('login', function ($request) {
    dump($request);
});

Scope::get('restful', \app\scope\data\Express::class, 'get');
Scope::post('restful', \app\scope\data\Express::class, 'post');
Scope::put('restful', \app\scope\data\Express::class, 'put');
Scope::patch('restful', \app\scope\data\Express::class, 'delete');

Scope
    ::middleware(\app\middleware\Before::class)
    ->middleware(\app\middleware\After::class, true)
    ->get('express', \app\scope\data\Express::class, 'getList');