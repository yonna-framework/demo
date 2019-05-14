<?php
// 加载composer模块
require __DIR__ . '/vendor/autoload.php';

use PhpureCore\Bootstrap;

$Dotenv = Dotenv\Dotenv::create(__DIR__);
$Dotenv->load();

dump($_SERVER,$_SERVER);

var_dump(getenv('APP_NAME'));
