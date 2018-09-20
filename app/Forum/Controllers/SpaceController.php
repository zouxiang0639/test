<?php

namespace App\Forum\Controllers;

use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\Users\UsersBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Auth;

/**
 * Created by MemberController.
 * @author: zouxiang
 * @date:
 */
class SpaceController extends Controller
{

    /**
     * 会员中心
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $userId)
    {
        $request->merge(['user_id' => $userId]);
        $user = UsersBls::find($userId);
        $this->isEmpty($user);

        $request->issuer = $user->id;
        $article = articleBls::getArticleLise($request);
        $article->getCollection()->each(function($item) {
            $item->replyCount = $item->reply()->count();
        });

        return view('forum::space.index', [
            'list' => $article,
            'current' => 1,
            'userName' => $user->name
        ]);
    }

    /**
     * 评论
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reply(Request $request, $userId)
    {
        $request->merge(['user_id' => $userId]);
        $user = UsersBls::find($userId);
        $this->isEmpty($user);
        $list = ReplyBls::replyJoinArticle($userId);
        return view('forum::space.reply', [
            'current' => 2,
            'list' => $list
        ]);
    }
}
