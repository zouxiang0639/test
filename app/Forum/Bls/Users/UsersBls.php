<?php

namespace App\Forum\Bls\Users;

use App\Forum\Bls\Users\Model\UsersModel;
use App\Forum\Bls\Users\Requests\RegisterUserRequest;
use Illuminate\Http\Request;

/**
 * Created by UsersBls.
 * @author: zouxiang
 * @date:
 */
class UsersBls
{

    /**
     * 创建用户
     * @param RegisterUserRequest $request
     * @return UsersModel|bool
     */
    public static function createUser(RegisterUserRequest $request)
    {
        $model = new UsersModel();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = bcrypt($request->password);

        if($model->save()) {
            return $model;
        }

        return false;
    }


    /**
     * 统计文章收藏
     * @param $issuer
     * @return mixed
     */
    public static function articlesStarCount($issuer)
    {
        return UsersModel::find($issuer)->articlesStar()->count();
    }

    /**
     * 统计文章推荐
     * @param $issuer
     * @return mixed
     */
    public static function articlesRecommendCount($issuer)
    {
        $user = \Auth::guard('forum')->user();
        return UsersModel::find($issuer)->articlesRecommend()->count();
    }

    /**
     * 用户登录策略
     * @param $user
     */
    public static function loginPolicy($user)
    {
        //清空当天发文章记录
        $lastLoginTime = mb_substr($user->last_login_time, 0, 10);
        $day = date('Y-m-d');
        if($lastLoginTime != $day) {
            $user->day_article = 0;
        }

        $user->last_login_time = date('Y-m-d H:i:s');
        $user->login_num ++;
        $user->save();
    }

    /**
     * 添加积分
     * @param $integral
     * @return mixed
     */
    public static function addIntegral($integral)
    {
        $user = \Auth::guard('forum')->user();
        $user->integral += $integral;
        return $user->save();

    }

    /**
     * 减积分
     * @param $integral
     * @return mixed
     */
    public static function minusIntegral($integral)
    {
        $user = \Auth::guard('forum')->user();
        $user->integral -= $integral;
        return $user->save();

    }


    /**
     * 签到
     * @param UsersModel $user
     * @return mixed
     */
    public static function userSignIn(UsersModel $user)
    {
        return UsersModel::query()->getQuery()->getConnection()->transaction(function () use($user) {
            $user->sign_time = date('Y-m-d H:i:s');
            UsersBls::addIntegral(5);
            return $user->save();
        });
    }

    public static function find($id)
    {
        return UsersModel::find($id);
    }

    public static function getUserByEmail($email)
    {
        return UsersModel::where('email', $email)->first();
    }

    public static function getUserByToken($token)
    {
        return UsersModel::where('remember_token', $token)->first();
    }

    public static function getUsersList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = UsersModel::query();


        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }


    public static function getUserByName($name)
    {
        return UsersModel::where('name', 'like', '%'.$name.'%')->get();
    }

}
