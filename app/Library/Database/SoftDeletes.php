<?php

namespace App\Library\Database;

trait SoftDeletes
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SoftDeletingScope);
    }

    /**
     * 只获取软删除的记录
     *
     * @return IlluminateDatabaseEloquentBuilder|static
     */
    public static function onlyTrashed()
    {
        $instance = new static;

        $column = $instance->getQualifiedDeletedAtColumn();

        return $instance->newQueryWithoutScope(new SoftDeletingScope)->where($column, '!=', "0000-00-00 00:00:00");
    }

    /**
     * Get a new query builder that includes soft deletes.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function withTrashed()
    {
        return (new static)->newQueryWithoutScope(new SoftDeletingScope);
    }
}