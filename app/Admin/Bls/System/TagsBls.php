<?php

namespace App\Admin\Bls\System;

use App\Admin\Bls\System\Model\TagsModel;
use App\Admin\Bls\System\Requests\TagsRequest;
use Illuminate\Http\Request;

/**
 * Created by TagsBls.
 * @author: zouxiang
 * @date:
 */
class TagsBls
{
    /**
     * 获取TAG列表
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getTagsList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = TagsModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        $model->where('type', $request->type);

        return $model->orderBy('hot', 'DESC')->orderByRaw($order)->paginate($limit);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return TagsModel::find($id);
    }

    /**
     * 存储标签
     * @param TagsRequest $request
     * @return bool
     */
    public static function storeTags(TagsRequest $request)
    {
        $model = new TagsModel();
        $model->type = $request->type;
        $model->tag_name = $request->tag_name;
        $model->status = $request->status;
        $model->color = $request->color;
        $model->icon = $request->icon;
        $model->hot = intval($request->hot);
        $model->contents = $request->contents;
        return $model->save();
    }

    /**
     * 更新标签
     * @param $model
     * @param TagsRequest $request
     * @return mixed
     */
    public static function updateTags($model, TagsRequest $request)
    {
        $model->type = $request->type;
        $model->tag_name = $request->tag_name;
        $model->status = $request->status;
        $model->color = $request->color;
        $model->icon = $request->icon;
        $model->hot = intval($request->hot);
        $model->contents = $request->contents;
        return $model->save();
    }
}