<?php

use Yonna\Config\Database;


Database::mysql(
    'default', [
        'host' => Database::env('DB_MY_1_HOST'),
        'port' => Database::env('DB_MY_1_PORT'),
        'account' => Database::env('DB_MY_1_ACCOUNT'),
        'password' => Database::env('DB_MY_1_PASSWORD'),
        'name' => Database::env('DB_MY_1_NAME'),
        'charset' => Database::env('DB_MY_1_CHARSET'),
        'auto_cache' => Database::env('DB_MY_1_AUTO_CACHE'),
        'auto_crypto' => Database::env('DB_MY_1_AUTO_CRYPTO'),
        'crypto_type' => Database::env('DB_MY_1_CRYPTO_TYPE'),
        'crypto_secret' => Database::env('DB_MY_1_CRYPTO_SECRET'),
        'crypto_iv' => Database::env('DB_MY_1_CRYPTO_IV'),
    ]
);

Database::redis(
    'redis', [
        'host' => Database::env('DB_REDIS_1_HOST'),
        'port' => Database::env('DB_REDIS_1_PORT'),
        'password' => Database::env('DB_REDIS_1_PASSWORD'),
        'project_key' => Database::env('DB_REDIS_1_PROJECT_KEY'),
    ]
);

Database::redis(
    'cache', [
        'host' => Database::env('DB_CACHE_HOST'),
        'port' => Database::env('DB_CACHE_PORT'),
        'password' => Database::env('DB_CACHE_PASSWORD'),
        'project_key' => Database::env('DB_CACHE_PROJECT_KEY'),
    ]
);
