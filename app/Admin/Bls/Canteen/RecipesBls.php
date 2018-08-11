<?php

namespace App\Admin\Bls\Canteen;

use App\Admin\Bls\Canteen\Model\RecipesModel;
use App\Admin\Bls\Canteen\Requests\RecipesRequest;
use Illuminate\Http\Request;


class RecipesBls
{
    /**
     * 获取外卖列表
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getTakeoutList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = RecipesModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }
        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function storeTakeout(RecipesRequest $request)
    {
        $model = new RecipesModel();
        $model->date = $request->date;
        $model->morning = $request->morning;
        $model->lunch = $request->lunch;
        $model->dinner = $request->dinner;
        return $model->save();
    }

    public static function updateTakeout(RecipesRequest $request, RecipesModel $model)
    {
        $model->date = $request->date;
        $model->morning = $request->morning;
        $model->lunch = $request->lunch;
        $model->dinner = $request->dinner;
        return $model->save();
    }

    public static function find($id)
    {
        return RecipesModel::find($id);
    }

}