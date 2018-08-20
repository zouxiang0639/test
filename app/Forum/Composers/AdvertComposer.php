<?php

namespace App\Forum\Composers;

use App\Consts\Admin\Other\AdvertTypeConst;
use App\Library\Admin\Widgets\Advert;


/**
 * Composer服务提供类
 * 更个随机广告
 */
class AdvertComposer
{
    public function compose($view)
    {
        $advert = (new Advert())->setType(AdvertTypeConst::SQUARE)->random(8);
        $view->with(compact('advert'));
    }
}
