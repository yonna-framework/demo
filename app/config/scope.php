<?php

use PhpureCore\Config\Scope;

Scope::get('test', function ($request) {
    echo '666666';
});
Scope::get('test', function ($request) {
    echo '777777';
});

Scope::post('login', function ($request) {
    dump($request);
});