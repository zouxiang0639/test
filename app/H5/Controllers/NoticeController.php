<?php

namespace App\H5\Controllers;

use App\Admin\Bls\Contents\NoticeBls;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

/**
 * 公告
 * Created by NoticeController.
 * @author: zouxiang
 * @date:
 */
class NoticeController  extends Controller
{

    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $list = NoticeBls::getNoticeList($request);

        return View::make('h5::notice.index',[
            'list' => $list
        ]);
    }

    public function show($id)
    {
        $model = NoticeBls::find($id);
        $this->isEmpty($model);

        return View::make('h5::notice.show',[
            'info' => $model
        ]);
    }

}
