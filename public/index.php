<?php
/**
 * 加载 composer 模块
 * 如果报错请安装 composer 并执行 composer install 安装所需要的包库
 *
 * Load composer modules
 * Install composer and exec composer install in your shell when error throw.
 */


require __DIR__ . '/../vendor/autoload.php';

PhpureCore\Core::bootstrap(
    realpath(__DIR__ . '/../'),
    'example',
    PhpureCore\Mapping\BootType::AJAX_HTTP
);

/*
$ctx = \Str::randomLetter(random_int(100,100000));
$name = md5($ctx);
$a = \Convert::limitConvert($name, 16);
$a = str_pad($a, 25, '0');
$a = str_split($a, 5);
$a = __DIR__ . '/f/' . implode(DIRECTORY_SEPARATOR, $a) . DIRECTORY_SEPARATOR;
\System::dirCheck($a,true);
file_put_contents("{$a}{$name}", $ctx);
var_dump($a);
exit();
 */