<?php

use PhpureCore\Config\Database;


Database::mysql(
    'default', [
        'host' => Database::env('DB_MY_1_HOST'),
        'port' => Database::env('DB_MY_1_PORT'),
        'account' => Database::env('DB_MY_1_ACCOUNT'),
        'password' => Database::env('DB_MY_1_PASSWORD'),
        'name' => Database::env('DB_MY_1_NAME'),
        'charset' => Database::env('DB_MY_1_CHARSET'),
        'auto_cache' => Database::env('DB_MY_1_AUTO_CACHE')
    ]
);

Database::redis(
    'redis', [
        'host' => Database::env('DB_REDIS_1_HOST'),
        'port' => Database::env('DB_REDIS_1_PORT'),
        'password' => Database::env('DB_REDIS_1_PASSWORD')
    ]
);

Database::redis(
    'cache', [
        'host' => Database::env('DB_REDIS_1_HOST'),
        'port' => Database::env('DB_REDIS_1_PORT'),
        'password' => Database::env('DB_REDIS_1_PASSWORD')
    ]
);
