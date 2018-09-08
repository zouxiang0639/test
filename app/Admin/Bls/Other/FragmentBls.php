<?php

namespace App\Admin\Bls\Other;

use App\Admin\Bls\Other\Model\FragmentModel;
use App\Admin\Bls\Other\Requests\FragmentRequests;
use Illuminate\Http\Request;

class FragmentBls
{
    /**
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getFragmentList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = FragmentModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    /**
     * @param FragmentRequests $requests
     * @return bool
     */
    public static function storeFragment(FragmentRequests $requests)
    {
        $model = new FragmentModel();
        $model->title = $requests->title;
        $model->picture = $requests->picture ?: '';
        $model->links = $requests->links ?: '';
        $model->contents = $requests->contents ?: '';
        return $model->save();
    }

    /**
     * @param FragmentModel $model
     * @param FragmentRequests $requests
     * @return bool
     */
    public static function updateFragment(FragmentModel $model, FragmentRequests $requests)
    {
        $model->title = $requests->title;
        $model->picture = $requests->picture ?: '';
        $model->links = $requests->links ?: '';
        $model->contents = $requests->contents ?: '';
        return $model->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        return  FragmentModel::find($id);
    }
}

