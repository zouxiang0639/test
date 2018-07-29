<?php

namespace App\Forum\Bls\Users;

use App\Forum\Bls\Users\Model\UsersModel;
use App\Forum\Bls\Users\Requests\RegisterUserRequest;

class UsersBls
{

    public static function createUser(RegisterUserRequest $request)
    {
        $model = new UsersModel();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = $request->password;

        if($model->save()) {
            return $model;
        }

        return false;
    }
}
