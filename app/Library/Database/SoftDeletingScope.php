<?php
namespace App\Library\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SoftDeletingScope extends \Illuminate\Database\Eloquent\SoftDeletingScope{

    /**
     * 只获取正常数据
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedDeletedAtColumn(), '=', '0000-00-00 00:00:00');

        $this->extend($builder);
    }

    /**
     * 只获取软删除数据
     * @param Builder $builder
     */
    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $model = $builder->getModel();

            $this->remove($builder, $model);

            $builder->where($model->getQualifiedDeletedAtColumn(), '!=', '0000-00-00 00:00:00');

            return $builder;
        });
    }

    /**
     * 去掉软删除条件
     * @param array $where
     * @param string $column
     * @return bool
     */
    protected function isSoftDeleteConstraint(array $where, $column)
    {
        return $where['type'] == 'Basic' &&
            $where['operator']=='=' &&
            $where['value'] == '0000-00-00 00:00:00' &&
            $where['column'] == $column;
    }

    public function remove(Builder $builder, Model $model)
    {
        $column = $model->getQualifiedDeletedAtColumn();

        $query = $builder->getQuery();
        $bindings = $query->getBindings();
        $wheres = $tmpBind = [];
        foreach ($query->wheres as $key=>$value){
            $isSoftDelete = $this->isSoftDeleteConstraint($value, $column);
            if(!$isSoftDelete){
                $wheres[] = $value;
            }else{
                unset($bindings[$key]);
            }
        }
        $query->wheres = array_values($wheres);
        $query->setBindings(array_values($bindings));
    }
}