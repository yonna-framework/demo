<?php
/**
 * 加载 composer 模块
 * 如果报错请安装 composer 并执行 composer install 安装所需要的包库
 *
 * Load composer modules
 * Install composer And exec composer install in your shell when throw error.
 */
require __DIR__ . '/vendor/autoload.php';

use PhpureCore\Bootstrap;
use PhpureCore\Bootstrap\Creator;

$Creator = (new Creator());
$Creator->setRoot(realpath(__DIR__));
$Creator->setEnv(true);
$Creator->setDebug(true);
$Creator->setTimezone('PRC');
$Bootstrap = new Bootstrap($Creator);
$Bootstrap->start();