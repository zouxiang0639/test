<?php

namespace App\Library\Forum\Widgets;

use App\Admin\Bls\System\Model\TagsModel;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\WhetherConst;

class Tags
{

    private $tags;

    public function __construct($type = TagsTypeConst::TAG)
    {
        if(empty($this->tags)) {
            $this->tags = TagsModel::where('type', $type)->where('status', WhetherConst::YES)
                ->get()->keyBy('id');
        }

    }

    public function getTagsName($tagId)
    {
        if($model = array_get($this->tags, $tagId)) {
            return $model->tag_name;
        }
        return '-';
    }

    public function getTags($tagId)
    {
        if($model = array_get($this->tags, $tagId)) {
            return $model;
        }
        return '-';
    }

    public function getTagsList()
    {
       return $this->tags;
    }

    public function getTagsOption()
    {
        return $this->tags->pluck('tag_name', 'id');
    }

    public function getTagsIcon($tagId)
    {
        if($model = array_get($this->tags, $tagId)) {
            return $model->icon;
        }
    }
}