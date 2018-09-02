<?php

namespace App\Forum\Bls\Article;
use App\Consts\Common\WhetherConst;
use App\Forum\Bls\Article\Model\InfoModel;

/**
 * Class InfoBls.
 */
class InfoBls
{

    /**
     * @param $userId
     * @param $operatorId
     * @param $type
     * @param $content
     * @return bool
     */
    public static function createInfo($userId, $operatorId, $type, $content)
    {
        $model = new InfoModel();
        $model->user_id = $userId;
        $model->operator_id = $operatorId;
        $model->type = $type;
        $model->content = $content;
        $model->sign = WhetherConst::NO;
        return $model->save();
    }


    /**
     * 文章列表
     * @param $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getInfoList($request, $order = '`id` DESC', $limit = 20)
    {
        $model = InfoModel::query();

        //发布人
        if(!empty($request->user_id)) {
            $model->where('user_id', $request->user_id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }


    /**
     * 统计新信息
     * @param $userId
     * @param null $sign 标记
     * @return int
     */
    public static function countInfo($userId, $sign = null)
    {
        $model = InfoModel::query();
        if($sign) {
            $model->where('sign', $sign);
        }
        $model->where('user_id', $userId);
        return $model->count();
    }

    /**
     * 把新信息设置已读
     * @param $userId
     * @return mixed
     */
    public static function signByYes($userId)
    {
        return InfoModel::where('user_id', $userId)->where('sign', WhetherConst::NO)->update(['sign' => WhetherConst::YES]);
    }
}

