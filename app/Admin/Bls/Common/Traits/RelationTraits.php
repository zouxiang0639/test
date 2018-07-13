<?php

namespace App\Admin\Bls\Common\Traits;


trait RelationTraits
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

    /**
     * 关联数据更新
     * @param $model
     * @param $relations
     */
    public static function deleteRelation($model, $relations)
    {

        foreach($relations as $name) {

            if(! $model->$name) {
                continue;
            }

            $relation = $model->$name();
            $relation->sync([]);
        }

    }
}