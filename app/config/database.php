<?php


use Yonna\Database\Config;


Config::mysql(
    'default', [
        'host' => Config::env('DB_MY_HOST'),
        'port' => Config::env('DB_MY_PORT'),
        'account' => Config::env('DB_MY_ACCOUNT'),
        'password' => Config::env('DB_MY_PASSWORD'),
        'name' => Config::env('DB_MY_NAME'),
        'charset' => Config::env('DB_MY_CHARSET'),
        'auto_cache' => Config::env('DB_MY_AUTO_CACHE'),
    ]
);

Config::redis(
    'redis', [
        'host' => Config::env('DB_REDIS_HOST'),
        'port' => Config::env('DB_REDIS_PORT'),
        'password' => Config::env('DB_REDIS_PASSWORD'),
        'project_key' => Config::env('DB_REDIS_PROJECT_KEY'),
    ]
);

Config::redis(
    'cache', [
        'host' => Config::env('DB_CACHE_HOST'),
        'port' => Config::env('DB_CACHE_PORT'),
        'password' => Config::env('DB_CACHE_PASSWORD'),
        'project_key' => Config::env('DB_CACHE_PROJECT_KEY'),
    ]
);
