<?php

namespace app\listener;

use Yonna\Event\Listener;

class Demo extends Listener
{

    public function handle()
    {
        var_dump('I am the listen demo,very simple');
    }

}