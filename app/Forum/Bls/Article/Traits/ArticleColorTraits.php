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
}