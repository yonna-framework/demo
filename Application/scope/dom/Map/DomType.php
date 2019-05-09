<?php

namespace Dom\Map;


class DomType extends \Common\Map\AbstractMap
{

    const article = 'article';
    const pics = 'pics';

    public function __construct()
    {
        $this->set(self::article, '文章');
        $this->set(self::pics, '图集');
    }

}