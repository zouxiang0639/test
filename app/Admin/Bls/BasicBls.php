<?php

namespace App\Admin\Bls;

abstract class BasicBls
{
    /**
     * 关联数据更新
     * @param $model
     * @param $relationsData
     */
    public static function updateRelation($model, $relationsData)
    {
        foreach($relationsData as $name => $value) {
            if(is_null($value)) {
                continue;
            }
            $relation = $model->$name();
            $relation->sync($value);
        }

    }
}