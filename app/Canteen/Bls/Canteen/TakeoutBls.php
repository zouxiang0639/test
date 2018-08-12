<?php

namespace App\Canteen\Bls\Canteen;


use App\Admin\Bls\Canteen\Model\TakeoutModel;
use App\Consts\Common\WhetherConst;

class TakeoutBls
{
    public static function getTakeoutList()
    {
        return TakeoutModel::where('status', WhetherConst::YES)->get();
    }
    public static function find($id)
    {
        return TakeoutModel::find($id);
    }
}
