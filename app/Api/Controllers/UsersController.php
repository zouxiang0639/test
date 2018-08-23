<?php

namespace App\Api\Controllers;

use App\Api\Bls\Users\Requests\UsersRegisterRequests;
use App\Api\Bls\Users\Requests\UsersShowRequests;
use App\Canteen\Bls\Users\UsersBls;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;


class UsersController extends ApiController
{

    /**
     * 创建用户
     * @param UsersRegisterRequests $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UsersRegisterRequests $request)
    {
        if(UsersBls::storeUsers($request)) {
            return $this->success('创建成功');
        } else {
            return $this->error(1010002);
        }
    }

    /**
     * 获取用户数据
     * @param UsersShowRequests $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(UsersShowRequests $request)
    {
        $model = UsersBls::getUsersByMobile($request->mobile);
        if(is_null($model)) {
            return $this->error(1050003);
        }
        return $this->success($model->toArray());
    }
}
