<?php

use Yonna\Config\Broadcast;

Broadcast::scope('test', function () {
    $a = 1;
});