<?php

namespace App\Api\Controllers;

use App\Admin\Bls\System\TagsBls;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Http\Controllers\ApiController;


class TagsController extends ApiController
{

    /**
     * 分组
     * @return \Illuminate\Http\JsonResponse
     */
    public function group()
    {
        $model = TagsBls::getTagsByType(TagsTypeConst::TAG)->pluck('tag_name', 'id')->toArray();
        return $this->success($model);
    }
}
