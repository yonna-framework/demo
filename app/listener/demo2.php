<?php

namespace app\listener;

use PhpureCore\Event\Listener;

class demo2 extends Listener
{

    public function handle()
    {
        var_dump('I am the listen demo too, the event named ' . $this->getEvent()->name);
    }

}