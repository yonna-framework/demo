<?php

use Yonna\Config\Trigger;

Trigger::reg(\app\event\Demo::class, [
    \app\listener\Demo::class,
    \app\listener\Demo2::class,
]);

// 触发事件
// Trigger::act(\app\event\demo::class, [1, 312, 32, 43, 542, 5]);
