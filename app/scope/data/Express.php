<?php

namespace app\scope\data;

use app\scope\abstractScope;
use Yonna\Database\DB;
use Yonna\Database\Driver\Type;
use Yonna\Foundation\Str;
use Yonna\Log\MongoLog;
use Yonna\Throwable\Exception;

class Express extends abstractScope
{

    /**
     * @param \library\Mysql $model
     * @return \library\Mysql
     */
    private function bindWhere($model)
    {
        $bean = $this->getBean();
        $bean->getCode() && $model->equalTo('code', $bean->getCode());
        $bean->getName() && $model->like('name', "%" . $bean->getName() . "%");
        return $model;
    }

    /**
     * 获取列表
     * @return array
     */
    public function getList()
    {

        $db = DB::new();

        $db->startRecord();

        $db->redis()->set('a', Str::randomNum(50), 100);
        $db->redis()->set('b', Str::randomNum(50), 100);
        $db->redis()->set('c', Str::randomNum(50), 100);
        $db->redis()->set('d', Str::randomNum(50), 100);

        $db->redis()->mSet([
            'e' => Str::randomNum(50),
            'f' => Str::randomNum(50),
        ], 100);
        $r = $db->redis()->get(['a', 'b', 'c', 'd', 'e', 'f']);
        // 这里切成了索引2的数据库，后续也会一直用
        $db->redis()->select(2);
        $db->redis()->set('mzy', time());
        $inc = $db->redis()->incr('x', 1);
        $inc = $db->redis()->incr('x', 1);
        // 这里临时切成了索引3的数据库，用完会自动切回2数据库
        $db->redis()->select(3, function () use ($db) {
            $db->redis()->set('mzy', time());
            $inc = $db->redis()->incr('x', 7);
        });
        // 所以这句incr是干的索引2数据库了
        $inc = $db->redis()->incr('x', 1);
        exit();

        $b = $db->connect()->table('test')->page(0, 5);

        $db->connect()->table('test')->multi();

        $db->mongo()->collection('test')->insert(['a' => 1]);
        $db->mongo()->collection('test')->insertAll([
            ['a' => 1],
            ['a' => 2, 'b' => 3],
            ['a' => 3, 'c' => 4]
        ]);

        /*
        return '这是阿强返回的一个字符串';

        $b = DB::connect()->table('test')->page(0, 5);
        return $b;
        exit();

        $bean = $this->getBean();
        $model = $this->db()->table('data_express');
        $model = $this->bindWhere($model);
        if ($bean->getOrderBy()) {
            $model->orderByStr($bean->getOrderBy());
        } else {
            $model->orderBy('ordering', 'desc');
            $model->orderBy('code', 'asc');
        }
        if ($bean->getPage()) {
            $result = $model->page($bean->getPageCurrent(), $bean->getPagePer());
        } else {
            $result = $model->multi();
        }
        return $this->success($result);
        */
    }

    /**
     * 根据ID获取信息
     * @return array
     */
    public function getInfo()
    {
        $model = $this->db()->table('data_express');
        $result = $this->bindWhere($model)->one();
        return $this->success($result);
    }

    /**
     * 新增快递
     * @return array
     */
    public function add()
    {
        $bean = $this->getBean();
        if (!$bean->getName()) return $this->error('请填写名称');
        if (!$bean->getCode()) return $this->error('请填写代码');
        $one = $this->db()->table('data_express')->field('code')->where(array('code' => $bean->getCode()))->one();
        if ($one['code']) {
            return $this->error('快递已存在');
        }
        if (is_string($bean->getName())) {
            $name = str_replace('，', ',', $bean->getName());
            $name = explode(',', $name);
        } else {
            $name = (array)$bean->getName();
        }
        $data = array();
        $data['name'] = $name;
        $data['code'] = $bean->getCode();
        is_numeric($bean->getOrdering()) && $data['ordering'] = (int)$bean->getOrdering();
        try {
            if (!$this->db()->table('data_express')->insert($data)) {
                throw new \Exception($this->db()->getError());
            }
            $id = $this->db()->lastInsertId();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success($id);
    }

    /**
     * 编辑快递
     * @return array
     */
    public function edit()
    {
        $bean = $this->getBean();
        if (!$bean->getCode()) return $this->error('参数错误');
        try {
            $data = array();
            if ($bean->getName()) {
                if (is_string($bean->getName())) {
                    $name = str_replace('，', ',', $bean->getName());
                    $name = explode(',', $name);
                } else {
                    $name = (array)$bean->getName();
                }
                $data['name'] = $name;
            }
            is_numeric($bean->getOrdering()) && $data['ordering'] = (int)$bean->getOrdering();
            $this->db()->table('data_express')->equalTo('code', $bean->getCode())->update($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success();
    }


    /**
     * 删除快递
     * @return array
     */
    public function del()
    {
        if (!$this->getBean()->getCode()) return $this->error('参数丢失');
        try {
            $this->db()->table('data_express')->in('code', $this->getBean()->getCode())->delete();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success();
    }
}