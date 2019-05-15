<?php

use PhpureCore\Config\Broadcast;

Broadcast::scope('test', function () {
    $a = 1;
});