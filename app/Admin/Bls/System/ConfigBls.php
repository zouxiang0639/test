<?php

namespace App\Admin\Bls\System;

use App\Admin\Bls\System\Model\ConfigModel;
use App\Admin\Bls\System\Requests\ConfigRequest;
use Illuminate\Http\Request;
use DB;

/**
 * Created by ConfigBls.
 * @author: zouxiang
 * @date:
 */
class ConfigBls
{
    /**
     * 格式化配置数据
     * @var array
     */
    public $format = [
        //title' => [\App\Library\Format\FormatMoney::class, 'yuan2fen']
    ];

    /**
     * 获取配置列表
     * @param Request $request
     * @param string $order
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getConfigList(Request $request, $order = '`id` DESC', $limit = 20)
    {
        $model = ConfigModel::query();

        if(!empty($request->id)) {
            $model->where('id', $request->id);
        }

        return $model->orderByRaw($order)->paginate($limit);
    }

    /**
     * 存储配置
     * @param ConfigRequest $request
     * @return bool
     */
    public static function storeConfig(ConfigRequest $request)
    {
        $model = new ConfigModel();
        $model->name = $request->name;
        $model->value = $request->value;
        $model->description = $request->description;
        return $model->save();
    }

    /**
     * @param $id
     * @return ConfigModel
     */
    public static function find($id)
    {
        return ConfigModel::find($id);
    }

    /**
     * 更新配置
     * @param ConfigModel $model
     * @param ConfigRequest $request
     * @return bool
     */
    public static function updateConfig(ConfigModel $model, ConfigRequest $request)
    {
        $model->name = $request->name;
        $model->value = $request->value;
        $model->description = $request->description;
        return $model->save();
    }


    /**
     * 注入配置
     */
    public static function load()
    {
        if (DB::select('SHOW TABLES LIKE "admin_config"')) {
            $model = ConfigModel::all(['name', 'value'])->pluck('value', 'name')->toArray();
            config(['config' => $model]);
        }
    }

    /**
     * 获取所有的配置并且返回标识和值
     * @return array
     */
    public static function configPluck()
    {
        $model = ConfigModel::all(['name', 'value'])->pluck('value', 'name')->toArray();
        return $model;
    }

    /**
     * 获取需要格式的配置
     * @param $name
     * @return mixed
     */
    public function getFormat($name)
    {
        return array_get($this->format, $name);
    }

    /**
     * 批量更新配置
     * @param $array
     * @return bool
     */
    public function configUpdateByArray($array)
    {
        foreach($array as $key => $value) {
            $model = ConfigModel::where('name', $key)->first();
            if($model) {

                //格式配置数据
                if($obj = $this->getFormat($key)) {
                    $value = call_user_func($obj, $value);
                }

                $model->value = $value;
                $model->save();
            }
        }
        return true;
    }
}