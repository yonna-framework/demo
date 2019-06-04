<?php

namespace app\listener;

use PhpureCore\Event\Listener;

class demo extends Listener
{

    public function handle($params)
    {
        var_dump('I am the listen 1');
    }

}