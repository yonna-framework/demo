<?php
namespace System\Model;

class AbstractModel extends \Common\Model\AbstractModel{

    /**
     * 初始化
     */
    public function init__(){
        parent::init__();
        $this->allowPermission(array(
            'System.Map.getMap',
            'System.Map.getKV',
            'System.Auth.createEmailAuthCode',
            'System.Auth.createMobileAuthCode',
            'System.Data.sqlite',
        ));
    }

}