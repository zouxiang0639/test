<?php

namespace App\Admin\Bls\Contents;

use App\Admin\Bls\Contents\Model\NoticeModel;
use App\Admin\Bls\Contents\Requests\NoticeRequest;
use Illuminate\Http\Request;

/**
 * Created by TagsBls.
 * @author: zouxiang
 * @date:
 */
class NoticeBls
{

    /**
     * 获取配置列表
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getNoticeList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = NoticeModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    /**
     * 存储配置
     * @param NoticeRequest $request
     * @return bool
     */
    public static function storeNotice(NoticeRequest $request)
    {
        $model = new NoticeModel();
        $model->title = $request->title;
        $model->contents = $request->contents;
        return $model->save();
    }

    /**
     * @param $id
     * @return NoticeModel
     */
    public static function find($id)
    {
        return NoticeModel::find($id);
    }

    /**
     * 更新配置
     * @param NoticeModel $model
     * @param NoticeRequest $request
     * @return bool
     */
    public static function updateNotice(NoticeModel $model, NoticeRequest $request)
    {
        $model->title = $request->title;
        $model->contents = $request->contents;
        return $model->save();
    }

}