<?php

namespace App\Bls\Auth;

use App\Bls\Auth\Model\Administrator;
use Redirect;

/**
 * Class AdminUserBls.
 */
class AdminUserBls
{
    public static function getAdminUser(Redirect $request, $order = '`id` DESC', $limit = 20)
    {
        $model = Administrator::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function find($id)
    {
       return Administrator::where('id', $id)->first();
    }
}

