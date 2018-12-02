<?php

namespace App\Forum\Bls\Article;
use App\Consts\Admin\User\InfoTypeConst;
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
     * @param $articlesId
     * @return bool
     */
    public static function createInfo($userId, $operatorId, $type, $content, $articlesId = 0)
    {
        $model = new InfoModel();
        $model->user_id = $userId;
        $model->operator_id = $operatorId;
        $model->type = $type;
        $model->content = $content;
        $model->sign = WhetherConst::NO;
        $model->articles_id = $articlesId;
        return $model->save();
    }



    /**
     * @param InfoModel $model info模型
     * @param int $userId  用户ID
     * @param int $operatorId 操作人
     * @param int $type 类型
     * @param int $content 描述
     * @param int $articlesId 文章ID
     * @return bool
     */
    public static function updateInfo(InfoModel $model, $userId, $operatorId, $type, $content, $articlesId = 0)
    {
        $model->user_id = $userId;
        $model->operator_id = $operatorId;
        $model->type = $type;
        $model->content = $content;
        $model->sign = WhetherConst::NO;
        $model->articles_id = $articlesId;
        return $model->save();
    }

    /**
     * 文章列表
     * @param $request
     * @param string $order
     * @param int $limit
     * @param string $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getInfoList($request, $order = '`id` DESC', $limit = 20, $page = 'paginate')
    {
        $model = InfoModel::query();

        //发布人
        if(!empty($request->user_id)) {
            $model->where('user_id', $request->user_id);
        }

        //类型
        if(!empty($request->type)) {
            $model->where('type', $request->type);
        }

        $model->orderByRaw($order);

        if($page == 'paginate') {
            return $model->paginate($limit);
        } else {
            return $model->simplePaginate($limit);
        }
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
         $model = InfoModel::where('user_id', $userId)->where('sign', WhetherConst::NO)->get();
         foreach($model as $item) {
             $item->sign = WhetherConst::YES;

             //新文章发表统计 清除
             if($item->articles_id) {
                 $item->articles->count_new_reply = 0;
                 $item->articles->save();
             }

             $item->save();
         }
         return $model->count();
    }


    public static function getArticleReplyInfo($userId, $articlesId)
    {
        return InfoModel::where('user_id', $userId)->where('articles_id', $articlesId)->where('sign', WhetherConst::NO)->where('type', InfoTypeConst::ARTICLE_REPLY)->first();
    }
}

