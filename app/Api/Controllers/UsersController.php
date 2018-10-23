<?php

namespace App\Api\Controllers;

use App\Api\Bls\Users\Requests\UsersLoginRequests;
use App\Api\Bls\Users\Requests\UsersRegisterRequests;
use App\Api\Bls\Users\Requests\UsersShowRequests;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Common\WhetherConst;
use App\Http\Controllers\ApiController;
use App\Library\Admin\Widgets\Security;
use Illuminate\Http\Request;
use Auth;


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

    /**
     * 用户登录
     * @param UsersLoginRequests $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UsersLoginRequests $request)
    {
        $credentials = $request->only(['mobile', 'password']);

        if (Auth::guard('canteen')->attempt($credentials)) {
            if(Auth::guard('canteen')->user()->status == WhetherConst::NO) {
                return $this->error(1050009);
            }
            $user = Auth::guard('canteen')->user();

            if($divisions = $user->divisions) {
                $user->division = $divisions->tag_name;
            }

            $data = json_encode([
                'mobile' => $user->mobile,
                'time' => date("Y-m-d H:i:s")
            ]);
            $key = Security::key();
            $user->qr_code = Security::encrypt($data, $key);
            unset($user->divisions);
            return $this->success($user);
        } else {
            return $this->error(1050008);
        }
    }
}
