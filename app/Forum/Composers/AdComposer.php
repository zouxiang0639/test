<?php

namespace App\Forum\Composers;

use App\Library\Admin\Widgets\Advert;

/**
 * Composer服务提供类
 * 单个随机广告
 */
class AdComposer
{
    public function compose($view)
    {
        $ad = (new Advert())->random(1);
        $ad = array_get($ad, 0);
        $view->with(compact('ad'));
    }
}
