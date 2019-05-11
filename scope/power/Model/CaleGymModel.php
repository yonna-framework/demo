<?php

namespace Power\Model;

class CaleGymModel extends AbstractModel
{

    /**
     * @return \Power\Bean\CaleGymBean
     */
    protected function getBean()
    {
        return parent::getBean();
    }

    private function getViewModel()
    {
        return $this->db()->table('power_cale_gym')
            ->join('power_cale_gym', 'user', ['uid' => 'uid'], 'LEFT')
            ->field('*', 'power_cale_gym')
            ->field('login_name,email', 'user');
    }

    /**
     * @param \library\Mysql $model
     * @return \library\Mysql
     */
    private function bindWhere($model)
    {
        $bean = $this->getBean();
        $bean->getId() && $model->in('id', $bean->getId());
        $bean->getClient() && $model->in('client', $bean->getClient());
        $bean->getUid() && $model->in('uid', $bean->getUid());
        $bean->getLevel() && $model->in('level', $bean->getLevel());
        $bean->getScore() && $model->in('score', $bean->getScore());
        $bean->getSecond() && $model->in('second', $bean->getSecond());
        $bean->getCreateTime() && $model->between('create_time', $bean->getCreateTime());
        return $model;
    }

    /**
     * 获取列表
     * @return array
     */
    public function getList()
    {
        $bean = $this->getBean();
        $model = $this->getViewModel();
        $model = $this->bindWhere($model);
        if ($bean->getOrderBy()) {
            $model->orderByStr($bean->getOrderBy());
        }
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
        $model = $this->getViewModel();
        $result = $this->bindWhere($model)->one();
        return $this->success($result);
    }

    /**
     * 插入数据
     * @return bool|mixed
     */
    public function add()
    {
        $bean = $this->getBean();
        if (!is_numeric($bean->getLevel())) return $this->error('缺少等级');
        if (!is_numeric($bean->getScore())) return $this->error('缺少得分');
        if ($bean->getSecond() <= 0) return $this->error('读秒错误');
        $data = array();
        $data['create_time'] = $this->db()->now();
        $data['client'] = $this->getClientID();
        $data['level'] = $bean->getLevel();
        $data['scope'] = $bean->getScore();
        $data['second'] = $bean->getSecond();
        $bean->getUid() && $data['uid'] = $bean->getUid();
        try {
            $this->db()->table('power_cale_gym')->insert($data);
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
        if (!$bean->getId()) return $this->error('缺少ID');

        $data = array();
        $bean->getLevel() && $data['level'] = $bean->getLevel();
        is_numeric($bean->getScore()) && $data['scope'] = $bean->getScore();
        $bean->getSecond() > 0 && $data['second'] = $bean->getSecond();
        if ($data) {
            try {
                $this->db()->table('power_cale_gym')->equalTo('id', $bean->getId())->update($data);
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
        if (!$bean->getId() && !$bean->getUid() && !$bean->getClient()) {
            return $this->error('参数错误');
        }
        try {
            $model = $this->db()->table('power_cale_gym');
            $bean->getId() && $model->in("id", $bean->getId());
            $bean->getUid() && $model->in("uid", $bean->getUid());
            $bean->getClient() && $model->in("client", $bean->getClient());
            $model->delete();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success();
    }

}