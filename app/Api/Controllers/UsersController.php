<?php

namespace App\Api\Controllers;

use App\Api\Bls\Users\Requests\UsersRegisterRequests;
use App\Canteen\Bls\Users\UsersBls;
use App\Http\Controllers\ApiController;


class UsersController extends ApiController
{
    public function register(UsersRegisterRequests $request)
    {

        if(UsersBls::storeUsers($request)) {
            return $this->success('创建成功');
        } else {
            return $this->error(1010002);
        }
    }
}
