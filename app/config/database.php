<?php

use PhpureCore\Config\Database;


Database::mysql(
    'default',
    getenv('DB_MY_1_HOST'),
    getenv('DB_MY_1_PORT'),
    getenv('DB_MY_1_ACCOUNT'),
    getenv('DB_MY_1_PASSWORD'),
    getenv('DB_MY_1_NAME'),
    getenv('DB_MY_1_CHARSET'),
    );