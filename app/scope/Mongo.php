<?php

namespace app\scope;

use Yonna\Database\DB;
use Yonna\Throwable\Exception;

class Mongo extends abstractScope
{

    /**
     * @return array
     * @throws Exception\DatabaseException
     */
    public function index()
    {
        $res = DB::mongo()->collection('test')
            ->greaterThan('age', 10)
            ->multi();
        return $res;
    }

    /**
     * @return array
     * @throws Exception\DatabaseException
     */
    public function info()
    {
        $res = DB::mongo()->collection('test')->multi();
        return $res;
    }

    /**
     * @return array
     * @throws Exception\DatabaseException
     */
    public function insert()
    {
        $data = [
            'name' => 'mzy',
            'age' => random_int(1, 99),
        ];
        $res = DB::mongo()->collection('test')->insert($data);
        return $res;
    }


}