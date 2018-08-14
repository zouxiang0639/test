<?php

namespace App\Admin\Bls\Other\Model;

use Illuminate\Database\Eloquent\Model;

class AdvertModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_advert';

    /**
     * 图片
     * @param string $picture
     *
     * @return string
     */
    public function getPictureAttribute($picture)
    {
        if ($picture) {
            return uploads_path($picture);
        }

        return uploads_path(config('config.default_picture'));
    }
}
