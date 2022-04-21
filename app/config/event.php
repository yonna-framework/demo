<?php


use Yonna\Event\Config;

Config::reg(\App\Event\Demo::class, [
    \App\Listener\Demo::class,
    \App\Listener\Demo2::class,
]);

// 触发事件
// Trigger::act(\App\Event\Demo::class, [1, 312, 32, 43, 542, 5]);
