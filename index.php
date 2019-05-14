<?php
// 加载composer模块
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