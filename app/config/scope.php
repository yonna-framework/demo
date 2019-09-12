<?php

use Yonna\Scope\Config;


Config::get('test', \app\scope\Test::class, 'index');

Config::get('testex', \app\scope\Test::class, 'exception');
