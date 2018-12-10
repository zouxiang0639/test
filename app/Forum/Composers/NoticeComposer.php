<?php

namespace App\Forum\Composers;

use App\Admin\Bls\Contents\NoticeBls;
use App\Consts\Common\WhetherConst;

/**
 * Composer服务提供类
 * 首页公共
 */
class NoticeComposer
{
    public function compose($view)
    {
        $noticeList = NoticeBls::getNoticeByIsHome(WhetherConst::YES);

        $view->with(compact('noticeList'));
    }
}
