<?php
/**
 * 加载 composer 模块
 * 如果报错请安装 composer 并执行 composer install 安装所需要的包库
 *
 * Load composer modules
 * Install composer and exec composer install in your shell when error throw.
 */

require __DIR__ . '/../vendor/autoload.php';

$ResponseCollector = Yonna\Core::bootstrap(
    realpath(__DIR__ . '/../'),
    'example',
    Yonna\Mapping\BootType::AJAX_HTTP
);

/**
 * end response
 */
$ResponseCollector->end();
