<?php

use Yonna\Scope\Config;


Config::get('test', \app\scope\Test::class, 'index');

Config::group('test',function (){
    Config::group('ws',function (){
        Config::stream('1', \app\scope\Test::class, 'index');
    });
});
Config::stream('ws2', function (){
    return 2019;
});

Config::get('testex', \app\scope\Test::class, 'exception');

Config::get('mongo', \app\scope\Mongo::class, 'index');
Config::patch('mongoi', \app\scope\Mongo::class, 'info');
Config::post('mongo', \app\scope\Mongo::class, 'insert');
Config::put('mongo', \app\scope\Mongo::class, 'modify');
