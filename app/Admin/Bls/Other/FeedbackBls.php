<?php

namespace App\Admin\Bls\Other;

use App\Admin\Bls\Other\Model\FeedbackModel;
use Illuminate\Http\Request;

class FeedbackBls
{
    public static function getFeedbackList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = FeedbackModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        if(!empty($request->type)) {
            $model->where('type', $request->type);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    public static function find($id)
    {
        return  FeedbackModel::find($id);
    }
}

