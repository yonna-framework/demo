<?php

use Yonna\Scope\Config;


Config::get('test', \app\scope\Test::class, 'index');

Config::get('testex', \app\scope\Test::class, 'exception');

Config::get('mongo', \app\scope\Mongo::class, 'index');
Config::patch('mongoi', \app\scope\Mongo::class, 'info');
Config::post('mongo', \app\scope\Mongo::class, 'insert');
Config::put('mongo', \app\scope\Mongo::class, 'modify');
