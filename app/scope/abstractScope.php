<?php

namespace App\Scope;

use App\Helper\Assets;
use Yonna\Scope\Scope;

abstract class AbstractScope extends Scope
{

    protected function xoss_save($content)
    {
        if (!$content) {
            return null;
        }
        $src = Assets::getHtmlSource($content);
        if ($src != null) {
            foreach ($src['save'] as $k => $v) {
                $res = (new Xoss($this->request()))->saveFile($v);
                $content = str_replace($k, Xoss::ASSET . $res['xoss_key'], $content);
            }
        }
        return $content;
    }

}