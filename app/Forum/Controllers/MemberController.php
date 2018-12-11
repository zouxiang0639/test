<?php

namespace App\Forum\Controllers;

use App\Consts\Admin\User\InfoTypeConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use App\Forum\Bls\Article\InfoBls;
use App\Forum\Bls\Article\ReplyBls;
use App\Forum\Bls\Users\UsersBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;

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
            $time = mb_substr($item->created_at, 0, 10);
            $item->createdAt = $time == date('Y-m-d') ? mb_substr($item->created_at, 11, 5) : $time;
        });

        $count = InfoBls::countInfo(\Auth::guard('forum')->id(), WhetherConst::NO);

        if($count > 0) {
            InfoBls::signByYes(Auth::guard('forum')->id());
        }

        return view('forum::member.info', [
            'current' => 5,
            'list' => $model,
            'type' => InfoTypeConst::desc(),
            'count' => $count
        ]);
    }

    /**
     * 设置信息已读
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
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

    /**
     * 推荐
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setup()
    {
        $user = Auth::guard('forum')->user();
        return view('forum::member.setup', [
            'current' => 6,
            'info' => $user
        ]);
    }

    /**
     * 修改基本信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function setupBasic(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10|sensitive|unique:users,name',
        ],[
            'name.required' => '昵称不能为空',
            'name.unique' => '昵称已被使用',
            'name.max' => '昵称字数超出',
            'name.sensitive' => '昵称不能有敏感词汇',
        ]);

        if ($validator->fails()) {
            throw new LogicException(1010001, $validator->getMessageBag());
        }
        $user = Auth::guard('forum')->user();

        if($user->integral - 50 < 0) {
            throw new LogicException(1010002, '你的积分不够');
        }
        $user->integral -= 50;
        $user->name = $request->name;

        if ($user->save()) {
            return (new JsonResponse())->success('修改成功');
        } else {
            throw new LogicException(1010002, '修改失败');
        }
    }


    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function setupPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|max:255',
        ],[
            'old_password.required' => '原始密码不能为空',
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次输入的密码不一样',
        ]);

        if ($validator->fails()) {
            throw new LogicException(1010001, $validator->getMessageBag());
        }
        $user = Auth::guard('forum')->user();
        if(!Hash::check($request->old_password, $user->password)){
            throw new LogicException(1010001, [['原始密码错误']]);
        }
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return (new JsonResponse())->success('修改成功');
        } else {
            throw new LogicException(1010002, '修改是吧');
        }
    }

}
