<?php

use PhpureCore\Config\Scope;
use PhpureCore\IO\Request;

Scope::post('login', function (Request $request) {
    dump($request);
});