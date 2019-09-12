<?php

namespace app\scope;

use Yonna\Throwable\Exception;

class Test extends abstractScope
{

    /**
     * @return array
     */
    public function index(){
        return ['hello world'];
    }

    /**
     * @throws Exception\ThrowException
     */
    public function exception(){
        Exception::throw('hei~');
    }

}