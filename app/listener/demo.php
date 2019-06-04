<?php

namespace app\listener;

use PhpureCore\Event\Listener;

class demo extends Listener
{

    public function handle()
    {
        var_dump('I am the listen demo,very simple');
    }

}