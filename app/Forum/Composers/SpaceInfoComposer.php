<?php
namespace App\Forum\Composers;

use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\Users\UsersBls;
use Input;


/**
 * Composer服务提供类
 *
 */
class SpaceInfoComposer
{
    public function compose($view)
    {
        $info = UsersBls::find(Input::get('user_id'));
        $articleCount = ArticleBls::ArticleCount($info->id);
        $replyCount = ReplyBls::countReplyByUser($info->id);
        $articlesStarCount = UsersBls::articlesStarCount($info->id);
        $articlesRecommendCount = UsersBls::articlesRecommendCount($info->id);

        $view->with(compact('info', 'articleCount', 'replyCount', 'articlesStarCount', 'articlesRecommendCount'));
    }
}
