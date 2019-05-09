<?php
namespace System\Model;

class TipsI18nModel extends AbstractModel{

    /**
     * @return \System\Bean\TipsI18nBean
     */
    protected function getBean(){
        return parent::getBean();
    }

    /**
     * @param \library\Mysql $model
     * @return \library\Mysql
     */
    private function bindWhere($model)
    {
        $bean = $this->getBean();
        $bean->getDefault() && $model->like('default',"%".$bean->getDefault()."%");
        return $model;
    }

    /**
     * 获取列表
     * @return array
     */
    public function getList(){
        $bean = $this->getBean();
        $model = $this->db()->table('system_tips_i18n');
        $model = $this->bindWhere($model);
        if($bean->getPage()){
            $data = $model->page($bean->getPageCurrent(),$bean->getPagePer());
        }else{
            $data = $model->multi();
        }
        return $this->success($data);
    }

    /**
     * 获取数据
     * @return array
     */
    public function getInfo(){
        $model = $this->db()->table('system_tips_i18n');
        $result = $this->bindWhere($model)->one();
        return $this->success($result);
    }

    /**
     * 添加数据
     * @return array
     */
    public function add(){
        $bean = $this->getBean();
        if(!$bean->getDefault()) return $this->error('请输入默认值');
        $data =array();
        $data['default'] = $bean->getDefault();
        ($bean->getZhCn())  && $data['zh_cn'] = $bean->getZhCn();
        ($bean->getZhTw())  && $data['zh_tw'] = $bean->getZhTw();
        ($bean->getZhHk())  && $data['zh_hk'] = $bean->getZhHk();
        ($bean->getEnUs())  && $data['en_us'] = $bean->getEnUs();
        ($bean->getJaJp())  && $data['ja_jp'] = $bean->getJaJp();
        ($bean->getKoKr())  && $data['ko_kr'] = $bean->getKoKr();
        try{
            $this->db()->table('system_tips_i18n')->insert($data);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
        return $this->success();
    }

    /**
     * 更新数据
     * @return array
     */
    public function edit(){
        $bean = $this->getBean();
        if(!$bean->getDefault()) return $this->error('请输入默认值');
        $data =array();
        ($bean->getZhCn())  && $data['zh_cn'] = $bean->getZhCn();
        ($bean->getZhTw())  && $data['zh_tw'] = $bean->getZhTw();
        ($bean->getZhHk())  && $data['zh_hk'] = $bean->getZhHk();
        ($bean->getEnUs())  && $data['en_us'] = $bean->getEnUs();
        ($bean->getJaJp())  && $data['ja_jp'] = $bean->getJaJp();
        ($bean->getKoKr())  && $data['ko_kr'] = $bean->getKoKr();
        if($data){
            try{
                $this->db()->table('system_tips_i18n')->equalTo('default',$bean->getDefault())->update($data);
            }catch (\Exception $e){
                return $this->error($e->getMessage());
            }
        }
        return $this->success();
    }

    /**
     * 删除数据
     * @return array
     */
    public function del(){
        $bean = $this->getBean();
        if(!$bean->getDefault()) return $this->error('请输入默认值');
        try{
            $this->db()->table('system_tips_i18n')->equalTo('default',$bean->getDefault())->delete();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
        return $this->success();
    }

}