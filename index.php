<?php
/**
 * 加载 composer 模块
 * 如果报错请安装 composer 并执行 composer install 安装所需要的包库
 *
 * Load composer modules
 * Install composer And exec composer install in your shell when throw error.
 */
require __DIR__ . '/vendor/autoload.php';

PhpureCore\Container::singleton(PhpureCore\Interfaces\Bootstrap::class,
    realpath(__DIR__),
    'example',
    PhpureCore\Mapping\BootType::AJAX_HTTP
);

var_dump('index.php: end');
