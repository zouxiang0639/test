<?php

namespace App\Forum\Bls\Article\Traits;


trait ArticleColorTraits
{

    /**
     * 回复颜色
     * @var array
     */
    public $color = [
        'green' => 'color-green',
        'lightGreen' => 'color-light-green',
        'white' => 'color-white',
        'lightRed' => 'color-light-red',
        'yellow' => 'color-yellow',
        'gray' => 'color-gray'
    ];


    public function getColor($model)
    {
        if($model->issuer == $this->articlesIssuer) {
            return $this->color['yellow'];
        } else if($model->thumbsDownCount - $model->thumbsUpCount > config('config.reply_light_red')) {
            return $this->color['lightRed'];
        } else if($model->thumbsUpCount >= config('config.reply_green')) {
            return $this->color['green'];
        } else if($model->thumbsUpCount >= config('config.reply_light_green')) {
            return $this->color['lightGreen'];
        } else {
            return $this->color['white'];
        }
    }
}