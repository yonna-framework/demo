<?php
require __DIR__ . '/vendor/autoload.php';

$core = new Dotenv();
var_dump($core);
var_dump(getenv('APP_NAME'));
