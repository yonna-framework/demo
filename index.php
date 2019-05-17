<?php
/**
 * 加载 composer 模块
 * 如果报错请安装 composer 并执行 composer install 安装所需要的包库
 *
 * Load composer modules
 * Install composer And exec composer install in your shell when throw error.
 */
require __DIR__ . '/vendor/autoload.php';

use PhpureCore\Bootstrap\Type;

// boot
$Creator = (new PhpureCore\Bootstrap\Creator());
$Creator->setRoot(realpath(__DIR__));
$Creator->setEnv('example'); // default: example
$Creator->setDebug(true); // default: false; 除了 creator 你也可以在 .env 设定
$Bootstrap = new PhpureCore\Bootstrap($Creator);
$Bootstrap->setType(Type::AJAX_HTTP);
$Bootstrap->io();

var_dump('end');
