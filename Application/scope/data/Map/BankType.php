<?php
namespace Data\Map;
/**
 * 银行库
 * Created by PhpStorm.
 * Date: 2018/10/12
 */
use Data\Model\BankLibModel;

class BankType extends \Common\Map\AbstractMap{

    public function __construct(){
        $libModel = new BankLibModel();
        $libList = $libModel->getListForMap__();
        if($libList){
            foreach($libList as $key=>$val){
                $this->set($val['data_bank_lib_code'],$val['data_bank_lib_name']);
            }
        }
    }

}