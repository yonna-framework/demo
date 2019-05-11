<?php
namespace Power\Model;

class AbstractModel extends \Common\Model\AbstractModel{

    /**
     * 初始化
     */
    public function init__(){
        parent::init__();
        $this->allowPermission(array(
            'Power.CaleGym.getList',
            'Power.CaleGym.add'
        ));
    }

}