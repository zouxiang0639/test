<?php

namespace App\Library\Admin\Widgets;
use App\Admin\Bls\Other\Model\AdvertModel;
use App\Consts\Admin\Other\AdvertTypeConst;
use App\Consts\Common\WhetherConst;


/**
 * 广告
 * Class Advert.
 */
class Advert
{
    protected $item;
    protected $type = AdvertTypeConst::BANNER;

    public function __construct()
    {
        if(empty($item)) {
            $model = AdvertModel::where('status', WhetherConst::YES)->orderBy('hot', 'desc')->orderBy('id', 'desc')->get();

            $model->each(function($item) {
                $this->item[$item->type][] = $item;
            });
        }
    }

    /**
     * 设置类型
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * 获取广告
     * @return mixed
     */
    public function getItem()
    {
        return array_get($this->item, $this->type);
    }


    /**
     * 获取随机广告
     * @param int $num
     * @return array
     */
    public function random($num)
    {
        $item = $this->getItem();
        shuffle($item);
        return array_slice($item, 0, $num);
    }

    /**
     * 截取广告
     * @param $num
     * @return array
     */
    public function intercept($num)
    {
        $item = $this->getItem();
        return array_slice($item, 0, $num);
    }

}