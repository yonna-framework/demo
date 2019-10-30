<?php

namespace app\scope;

use Yonna\Throwable\Exception;

class Test extends abstractScope
{

    /**
     * @return array
     */
    public function index(){
        foreach($this->request()->getSwoole()->connections as $fd)
        {
            $this->request()->getSwoole()->push($fd, "阿强" . date('Ymd His'));
        }
        return ['hello world'];
    }

    /**
     * @throws Exception\ThrowException
     */
    public function exception(){
        Exception::throw('hei~');
    }

}