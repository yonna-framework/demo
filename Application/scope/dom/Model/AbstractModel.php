<?php
namespace Dom\Model;

use Assets\Helper\Assets;

class AbstractModel extends \Common\Model\AbstractModel {

    /**
     * 初始化
     */
    public function init__(){
        parent::init__();
        $this->allowPermission(array(
            'Dom.DomCategory.getList',
            'Dom.DomCategory.getInfo',
            'Dom.Dom.getList',
            'Dom.Dom.getInfo',
        ));
    }

}