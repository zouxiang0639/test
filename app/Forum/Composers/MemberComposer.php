<?php
namespace App\Forum\Composers;
use App\Consts\Common\WhetherConst;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\InfoBls;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\Users\UsersBls;


/**
 * Composer服务提供类
 *
 */
class MemberComposer
{
    public function compose($view)
    {
        $info = \Auth::guard('forum')->user();
        $articleCount = ArticleBls::ArticleCount($info->id);
        $replyCount = ReplyBls::countReplyByUser($info->id);
        $articlesStarCount = UsersBls::articlesStarCount($info->id);
        $articlesRecommendCount = UsersBls::articlesRecommendCount($info->id);
        $infoCount = InfoBls::countInfo($info->id);

        $view->with(compact('info', 'articleCount', 'replyCount', 'articlesStarCount', 'articlesRecommendCount', 'infoCount'));
    }
}
