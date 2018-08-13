<?php

namespace App\Admin\Bls\Other;

use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Admin\Bls\Other\Requests\FeedbackRequests;
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

    public static function storeFeedback(FeedbackRequests $requests)
    {
        $model = new FeedbackModel();
        $model->type = $requests->type;
        $model->extend = $requests->extend;
        $model->users_id = $requests->users_id ?: 0;
        $model->contents = $requests->contents;
        return $model->save();
    }

    public static function find($id)
    {
        return  FeedbackModel::find($id);
    }
}

