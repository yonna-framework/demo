<?php
namespace Goods\Map;

class GoodsEvaluate extends \Common\Map\AbstractMap {

    const positive = 'positive';
    const moderate = 'moderate';
    const negative = 'negative';

    public function __construct(){
        $this->set(self::positive,  '好');
        $this->set(self::moderate,  '中');
        $this->set(self::negative,  '差');
    }

}