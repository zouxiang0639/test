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
            $this->tags = TagsModel::where('type', $type)->where('status', WhetherConst::YES)->orderBy('hot','desc')
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

    public function getTagsColor($tagId)
    {
        if($model = array_get($this->tags, $tagId)) {
            return $model->color;
        }
    }

    public function getTagsContents($tagId)
    {
        if($model = array_get($this->tags, $tagId)) {
            return $model->contents;
        }
    }

    public function getSpecifyTags($tagsID, $default = null)
    {
        $tag = self::getTagsOption();
        $array = [];
        foreach($tag as $key => $value) {
            if(in_array($key, $tagsID)) {
                $array[$key] = $value;
            }
        }

        return $array ?: $default;
    }
}