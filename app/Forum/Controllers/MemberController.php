<?php

namespace App\Forum\Controllers;

use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\ReplyBls;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class MemberController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::guard('forum')->user();
        $request->issuer = $user->id;
        $article = articleBls::getArticleLise($request);

        return view('forum::member.index', [
            'list' => $article,
            'current' => 1,
            'userName' => $user->name
        ]);
    }

    public function reply()
    {
        $userId = Auth::guard('forum')->id();
        $list = ReplyBls::replyJoinArticle($userId);
        return view('forum::member.reply', [
            'current' => 2,
            'list' => $list
        ]);
    }


    public function recommend()
    {
        $user = Auth::guard('forum')->user();
        $list = $user->articlesRecommend()->paginate(10);
        return view('forum::member.index', [
            'current' => 3,
            'list' => $list,
            'userName' => $user->name
        ]);
    }

    public function star()
    {
        $user = Auth::guard('forum')->user();
        $list = $user->articlesStar()->paginate(10);
        return view('forum::member.index', [
            'current' => 4,
            'list' => $list,
            'userName' => $user->name
        ]);
    }

    public function info()
    {

        return view('forum::member.info', [
            'current' => 5
        ]);
    }
}
