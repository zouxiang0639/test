<?php

namespace App\Admin\Bls\Other;

use App\Admin\Bls\Other\Model\AdvertModel;
use App\Admin\Bls\Other\Requests\AdvertRequests;
use Illuminate\Http\Request;

class AdvertBls
{
    /**
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getAdvertList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = AdvertModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        if(!empty($request->type)) {
            $model->where('type', $request->type);
        }

        return $model->orderBy('hot', 'DESC')->orderByRaw($order)->paginate($limit);
    }

    /**
     * @param AdvertRequests $requests
     * @return bool
     */
    public static function storeAdvert(AdvertRequests $requests)
    {
        $model = new AdvertModel();
        $model->type = $requests->type;
        $model->status = $requests->status;
        $model->hot = $requests->hot;
        $model->title = $requests->title;
        $model->picture = $requests->picture;
        $model->links = $requests->links ?: '';
        $model->comment = $requests->comment ?: '';
        return $model->save();
    }

    /**
     * @param AdvertModel $model
     * @param AdvertRequests $requests
     * @return bool
     */
    public static function updateAdvert(AdvertModel $model, AdvertRequests $requests)
    {
        $model->type = $requests->type;
        $model->status = $requests->status;
        $model->hot = $requests->hot;
        $model->title = $requests->title;
        $model->picture = $requests->picture;
        $model->links = $requests->links ?: '';
        $model->comment = $requests->comment ?: '';
        return $model->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return  AdvertModel::find($id);
    }
}

