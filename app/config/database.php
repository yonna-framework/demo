<?php

use PhpureCore\Config\Database;


Database::mysql(
    'default', [
        'host' => getenv('DB_MY_1_HOST'),
        'port' => getenv('DB_MY_1_PORT'),
        'account' => getenv('DB_MY_1_ACCOUNT'),
        'password' => getenv('DB_MY_1_PASSWORD'),
        'name' => getenv('DB_MY_1_NAME'),
        'charset' => getenv('DB_MY_1_CHARSET'),
        'auto_cache' => getenv('DB_MY_1_AUTO_CACHE')
    ]
);

Database::redis(
    'redis', [
        'host' => getenv('DB_REDIS_1_HOST'),
        'port' => getenv('DB_REDIS_1_PORT')
    ]
);

Database::redis(
    'cache', [
        'host' => getenv('DB_REDIS_1_HOST'),
        'port' => getenv('DB_REDIS_1_PORT')
    ]
);
