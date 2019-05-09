<?php

namespace System\Model;

class DataModel extends AbstractModel
{

    /**
     * @return \System\Bean\DataBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    /**
     * @param \library\Mysql $model
     * @return \library\Mysql
     */
    private function bindWhere($model)
    {
        $bean = $this->getBean();
        $bean->getKey() && $model->in('key', $bean->getKey());
        $bean->getName() && $model->like('name', "%" . $bean->getName() . "%");
        $bean->getData() && $model->json('data', $bean->getData());
        return $model;
    }

    /**
     * 通过指定key来获取value值
     * @param $key
     * @return mixed
     */
    public function getValueByKey__($key)
    {
        if (!$key) return array();
        if (is_array($key)) {
            $keys = $this->db()->table('system_data')->field('key,value')->in('key', $key)->multi();
            $result = array();
            foreach ($keys as $v) {
                $result[$v['key']] = $v;
            }
        } else {
            $result = $this->db()->table('system_data')->field('key,value')->equalTo("key", $key)->one();
        }
        return $result;
    }

    /**
     * 获取列表
     * @return array
     */
    public function getList()
    {
        $bean = $this->getBean();
        $model = $this->db()->table('system_data');
        $model = $this->bindWhere($model);
        if ($bean->getPage()) {
            $data = $model->page($bean->getPageCurrent(), $bean->getPagePer());
        } else {
            $data = $model->multi();
        }
        return $this->success($data);
    }

    /**
     * 获取数据
     * @return array
     */
    public function getInfo()
    {
        $model = $this->db()->table('system_data');
        $result = $this->bindWhere($model)->one();
        return $this->success($result);
    }

    /**
     * 获取数据以KEY分组
     * @return array
     */
    public function getInfoForKey()
    {
        $model = $this->db()->table('system_data');
        $model = $this->bindWhere($model);
        $data = $model->multi();
        $result = array();
        foreach ($data as $d) {
            $result[$d['system_data_key']] = $d;
        }
        return $this->success($result);
    }

    /**
     * 插入数据
     * @return bool|mixed
     */
    public function add()
    {
        $bean = $this->getBean();
        if (!$bean->getKey()) return $this->error('请输入配置的key');
        if (!$bean->getName()) return $this->error('请输入配置名称');
        if (strpos($bean->getKey(), '-') !== false) return $this->error('请不要输入“-”符号');
        $data = array();
        $data['key'] = $bean->getKey();
        $data['name'] = $bean->getName();
        $bean->getData() && $data['data'] = $bean->getData();
        try {
            $this->db()->table('system_data')->insert($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success();
    }

    /**
     * 更新数据
     * @return array
     */
    public function edit()
    {
        $bean = $this->getBean();
        if (!$bean->getKey()) return $this->error('请输入配置的key');

        $data = array();
        $bean->getName() && $data['name'] = $bean->getName();
        $bean->getData() && $data['data'] = $bean->getData();
        if ($data) {
            try {
                $this->db()->table('system_data')->equalTo('key', $bean->getKey())->update($data);
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }
        return $this->success();
    }

    /**
     * del
     * @return array
     */
    public function del()
    {
        $bean = $this->getBean();
        if (!$bean->getKey()) return $this->error('key丢失');
        try {
            $this->db()->table('system_data')->equalTo("key", $bean->getKey())->delete();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success();
    }

}