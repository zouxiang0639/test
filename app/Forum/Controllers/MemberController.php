<?php

namespace App\Forum\Controllers;

use App\Consts\Admin\User\InfoTypeConst;
use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\InfoBls;
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
class MemberController extends Controller
{

    /**
     * 会员中心
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::guard('forum')->user();
        $request->issuer = $user->id;
        $article = articleBls::getArticleLise($request);
        $article->getCollection()->each(function($item) {
            $item->replyCount = $item->reply()->count();
        });
        return view('forum::member.index', [
            'list' => $article,
            'current' => 1,
            'userName' => $user->name
        ]);
    }

    /**
     * 评论
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reply()
    {
        $userId = Auth::guard('forum')->id();
        $userName = Auth::guard('forum')->user()->name;
        $list = ReplyBls::replyJoinArticle($userId, 30);
        return view('forum::member.reply', [
            'current' => 2,
            'list' => $list,
            'userName' => $userName
        ]);
    }


    /**\
     * 推荐
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recommend()
    {
        $user = Auth::guard('forum')->user();
        $list = $user->articlesRecommend()->paginate(30);
        return view('forum::member.index', [
            'current' => 3,
            'list' => $list,
            'userName' => $user->name
        ]);
    }

    /**
     * 收藏
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function star()
    {
        $user = Auth::guard('forum')->user();
        $list = $user->articlesStar()->paginate(30);
        $list->getCollection()->each(function($item) {
            $item->replyCount = $item->reply()->count();
        });
        return view('forum::member.index', [
            'current' => 4,
            'list' => $list,
            'userName' => $user->name
        ]);
    }

    /**
     * 消息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info(Request $request)
    {
        $request->merge(['user_id' => Auth::guard('forum')->id()]);
        $model = InfoBls::getInfoList($request, '`id` DESC', 30);
        $model->getCollection()->each(function($item) {
            $item->typeName = InfoTypeConst::getDesc($item->type);
        });
        return view('forum::member.info', [
            'current' => 5,
            'list' => $model,
            'type' => InfoTypeConst::desc()
        ]);
    }

    public function infoSign()
    {
        if (InfoBls::signByYes(Auth::guard('forum')->id())) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002,'已经全部已读');
        }
    }

    /**
     * 签到
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function signIn()
    {
        $user = Auth::guard('forum')->user();
        $lastLoginTime = mb_substr($user->sign_time, 0, 10);
        $day = date('Y-m-d');
        if($lastLoginTime == $day) {
            throw new LogicException(1010002, '今天已经签到');
        }

        if (UsersBls::userSignIn($user)) {
            return (new JsonResponse())->success('签到成功');
        } else {
            throw new LogicException(1010002, '签到失败');
        }
    }

}
