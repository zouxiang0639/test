<?php

namespace App\Admin\Controllers\Report;

use App\Canteen\Bls\Users\Model\UsersModel;
use App\Consts\Common\WhetherConst;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function meal()
    {
        $userMoney = UsersModel::where('status', WhetherConst::YES)->count('money');
        dd($userMoney);
        return view('admin::report.user');
    }

    public function takeout()
    {

    }
}
