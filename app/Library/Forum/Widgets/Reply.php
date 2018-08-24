<?php

namespace App\Library\Forum\Widgets;

use App\Exceptions\LogicException;
use App\Forum\Bls\Article\ArticleBls;
use Auth;
use Illuminate\Contracts\Support\Renderable;

class Reply implements Renderable
{
    /**
     * 初始化数据
     * @var
     */
    protected $item;

    /**
     * 二维数据
     * @var
     */
    protected $tree;

    /**
     * 每页显示多少条数据
     * @var int
     */
    protected $limit = 10;

    /**
     * 当前用户ID
     * @var int|null
     */
    protected $userId;

    /**
     * 文章发布人
     * @var
     */
    protected $articlesIssuer;

    /**
     * 处理完成数据
     * @var
     */
    protected $data;

    /**
     * 渲染前端页面
     * @var string
     */
    protected $view = 'forum::reply.show';

    /**
     * 回复颜色
     * @var array
     */
    protected $color = [
           'green' => 'color-green',
           'lightGreen' => 'color-light-green',
           'white' => 'color-white',
           'lightRed' => 'color-light-red',
           'yellow' => 'color-yellow',
           'gray' => 'color-gray'
    ];

    /**
     *
     * Reply constructor.
     * @param $data
     */
    public function __construct($data, $articlesId)
    {
        $model = ArticleBls::find($articlesId);
        $this->articlesIssuer = $model->issuer;
        $this->item = $data;
        $this->userId = Auth::guard('forum')->id();
    }

    /**
     * 设置二维数据
     * @return $this
     */
    public function setTree()
    {

        foreach($this->item as $value) {
            if($value['parent_id'] == 0) {
                $children = self::children($value->id);
                $value->childrenCount = 0;

                if(!empty($children)) {
                    $value->children = $children;
                    $value->childrenCount = count($children);
                }

                $this->tree[] = $value;
            }
        }
        return $this;
    }

    /**
     * 子集数据
     * @param $parentId
     * @return array
     */
    protected function children($parentId)
    {
        $array = [];
        foreach($this->item as $value) {
            if($value->parent_id == $parentId) {
                $array[] = $value;
            }
        }
        return $array;
    }


    /**
     * 分页
     * @param $page
     * @return $this
     * @throws LogicException
     */
    public function getPage($page)
    {
        $offset = $page * $this->limit;
        $length = $offset + $this->limit;
        if(is_null($this->tree)) {
            throw new LogicException(1010001, '没有数据了');
        }
        $data = array_slice($this->tree, $offset, $length);

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

    /**
     * 设置一维数据
     * @return $this
     */
    public function setDate()
    {

        foreach ($this->item as $key => $value) {
            $this->data[] = $this->formatItem($value);
        }

        return $this;
    }


    /**
     * 格式数据
     * @param $model
     * @return mixed
     */
    protected function formatItem($model)
    {
        $model->issuerName = '-';  //发布人
        $model->thumbsUpCount = count($model->thumbs_up); //赞数量
        $model->thumbsUpCheck = in_array($this->userId, $model->thumbs_up); //是否赞过
        $model->thumbsDownCount = count($model->thumbs_down); //弱数量
        $model->thumbsDownCheck = in_array($this->userId, $model->thumbs_down); //是否弱过
        $model->isDelete = $this->userId == $model->issuer; //是否有删除的权限
        $model->formatPicture = explode(',', $model->picture); //图片
        $model->atName = ''; //@的用户名称
        $model->color = $this->getColor($model); //更近需求判断颜色

        //信息删除
        if(!is_null($model->deleted_at)) {
            $model->contents = '该回复已被删除';
            $model->formatPicture = [];
            $model->isDelete = false;
        }

        if($issuer = $model->issuers) {
            $model->issuerName = $issuer->name;
        }

        if(!empty($model->at) && $at = $model->ats) {
            $model->atName = $at->name;
        }

        return $model;
    }

    /**
     * 设置渲染的页面
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    protected function getColor($model)
    {
        if(!is_null($model->deleted_at)) {
            return $this->color['gray'];
        }

        if($model->issuer == $this->articlesIssuer) {
            return $this->color['yellow'];
        } else if($model->thumbsDownCount > 9) {
            return $this->color['lightRed'];
        } else if($model->thumbsUpCount > 99) {
            return $this->color['green'];
        } else if($model->thumbsUpCount > 9) {
            return $this->color['lightGreen'];
        } else {
            return $this->color['white'];
        }
    }


    /**
     * 获取渲染视图HTML代码
     * @param array $array  附加变量
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function render($array = [])
    {
        return view($this->view, array_merge(['list' => $this->data], $array))->render();
    }
}