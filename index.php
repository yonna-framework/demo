<?php
require __DIR__ . '/vendor/autoload.php';

$core = new HunzsigServer/PhpureCore();
var_dump($core);

$core = new Vlucas/Phpdotenv();
var_dump($core);
var_dump(getenv('APP_NAME'));
