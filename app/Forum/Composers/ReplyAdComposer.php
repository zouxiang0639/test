<?php

namespace App\Forum\Composers;

use App\Consts\Admin\Other\AdvertTypeConst;
use App\Library\Admin\Widgets\Advert;

/**
 * Composer服务提供类
 * 单个随机广告 评论
 */
class ReplyAdComposer
{
    public function compose($view)
    {
        $ad = (new Advert())->setType(AdvertTypeConst::REPLY_AD)->random(1);
        $replyAd = array_get($ad, 0);
        $view->with(compact('replyAd'));
    }
}
