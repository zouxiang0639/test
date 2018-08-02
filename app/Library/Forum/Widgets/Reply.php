<?php

namespace App\Library\Forum\Widgets;

use Auth;
use Illuminate\Contracts\Support\Renderable;

class Reply implements Renderable
{
    protected $item;
    protected $tree;
    protected $limit = 10;
    protected $userId;
    protected $data;
    protected $view = 'forum::reply.show';

    public function __construct()
    {
        $this->userId = Auth::guard('forum')->id();
    }

    public function setTree($data)
    {

        foreach($data as $value) {
            if($value['parent_id'] == 0) {
                $children = self::children($data, $value->id);
                $value->childrenCount = 0;

                if(!empty($children)) {
                    $value->children = $children;
                    $value->childrenCount = count($children);
                }

                $this->item[] = $value;
            }
        }
        return $this;
    }

    protected function children($data, $parentId)
    {
        $array = [];
        foreach($data as $value) {
            if($value->parent_id == $parentId) {
                $array[] = $value;
            }
        }
        return $array;
    }

    public function getItem($page)
    {
        $offset = $page * $this->limit;
        $length = $offset + $this->limit;
        $data = array_slice($this->item, $offset, $length);
        foreach($data as $key => $value){

            //子回复格式化数据并且只取2条
            if($value->childrenCount > 0 ) {
                $array = [];
                foreach ($value->children as $keys => $item) {
                    if($keys > 1) {
                        break;
                    }
                    $array[] = $this->formatItem($item);
                }
                $value->children = $array;
            }
            $data[$key] = $this->formatItem($value);
        }

        $this->data = $data;
        return $this;
    }

    public function setDate($data)
    {

        foreach ($data as $key => $value) {
            $this->data[] = $this->formatItem($value);
        }

        return $this;
    }

    protected function formatItem($model)
    {
        $model->issuerName = '-';  //发布人
        $model->thumbsUpCount = count($model->thumbs_up); //赞数量
        $model->thumbsUpCheck = in_array($this->userId, $model->thumbs_up); //是否赞过
        $model->thumbsDownCount = count($model->thumbs_down); //弱数量
        $model->thumbsDownCheck = in_array($this->userId, $model->thumbs_down); //是否弱过

        if($issuer = $model->issuers) {
            $model->issuerName = $issuer->name;
        }

        return $model;
    }

    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }


    public function render($array = [])
    {
        return view($this->view, array_merge(['list' => $this->data], $array))->render();
    }
}