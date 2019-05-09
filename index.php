<?php
require __DIR__ . '/vendor/autoload.php';

$Dotenv = Dotenv\Dotenv::create(__DIR__);
$Dotenv->load();

var_dump(getenv('APP_NAME'));
