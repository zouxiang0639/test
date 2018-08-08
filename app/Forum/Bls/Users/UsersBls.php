<?php

namespace App\Forum\Bls\Users;

use App\Forum\Bls\Users\Model\UsersModel;
use App\Forum\Bls\Users\Requests\RegisterUserRequest;

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
        $model->password = bcrypt($request->password);;

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
        static::loginPolicy($user);
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

}
