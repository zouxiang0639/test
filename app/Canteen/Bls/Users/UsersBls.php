<?php

namespace App\Canteen\Bls\Users;
use App\Api\Bls\Users\Requests\UsersRegisterRequests;
use App\Canteen\Bls\Users\Model\UsersModel;

/**
 * Created by UsersBls.
 * @author: zouxiang
 * @date:
 */
class UsersBls
{

    public static function storeUsers(UsersRegisterRequests $requests)
    {
        $model = new UsersModel();
        $model->division = $requests->tag;
        $model->name = $requests->name;
        $model->mobile = $requests->mobile;
        $model->password = bcrypt('123456');
        return $model->save();
    }
}
