<?php

use PhpureCore\Config\Scope;
use PhpureCore\IO\Request;

Scope::get('test', function (Request $request) {
    echo '666666';
});
Scope::get('test', function (Request $request) {
    echo '777777';
});

Scope::post('login', function (Request $request) {
    dump($request);
});