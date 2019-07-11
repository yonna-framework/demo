<?php

use Yonna\Database\Config;


Config::mysql(
    'default', [
        'host' => Config::env('DB_MY_1_HOST'),
        'port' => Config::env('DB_MY_1_PORT'),
        'account' => Config::env('DB_MY_1_ACCOUNT'),
        'password' => Config::env('DB_MY_1_PASSWORD'),
        'name' => Config::env('DB_MY_1_NAME'),
        'charset' => Config::env('DB_MY_1_CHARSET'),
        'auto_cache' => Config::env('DB_MY_1_AUTO_CACHE'),
        'auto_crypto' => Config::env('DB_MY_1_AUTO_CRYPTO'),
        'crypto_type' => Config::env('DB_MY_1_CRYPTO_TYPE'),
        'crypto_secret' => Config::env('DB_MY_1_CRYPTO_SECRET'),
        'crypto_iv' => Config::env('DB_MY_1_CRYPTO_IV'),
    ]
);

Config::mongo(
    'mongo', [
        'host' => Config::env('DB_MONGO_1_HOST'),
        'port' => Config::env('DB_MONGO_1_PORT'),
        'name' => Config::env('DB_MONGO_1_NAME'),
    ]
);

Config::redis(
    'redis', [
        'host' => Config::env('DB_REDIS_1_HOST'),
        'port' => Config::env('DB_REDIS_1_PORT'),
        'password' => Config::env('DB_REDIS_1_PASSWORD'),
        'project_key' => Config::env('DB_REDIS_1_PROJECT_KEY'),
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
