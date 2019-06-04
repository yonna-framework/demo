<?php

use PhpureCore\Config\Trigger;

Trigger::reg(\app\event\demo::class, [
    \app\listener\demo::class,
    \app\listener\demo2::class,
]);

// 触发事件
// Trigger::act(\app\event\demo::class, [1, 312, 32, 43, 542, 5]);
