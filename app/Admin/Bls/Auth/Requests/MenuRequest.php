<?php

namespace App\Admin\Bls\Auth\Requests;

use App\Library\Validators\JsonResponseValidator;
use Route;

class MenuRequest extends JsonResponseValidator
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        \Validator::extendImplicit('route', function ($attribute, $value, $parameters, $validator) {
            if(Route::has($value) || preg_match('/(http|https):\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $value)) {
                return true;
            }
            return false;
        });

        return [
            'parent_id' => 'required',
            'title' => 'required',
            'icon' => 'required',
            'route' => 'required|route',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'parent_id.required' => '请选择父级菜单',
            'title.required' => '标题不能为空',
            'icon.required' => '图标不能为空',
            'route.required' => '路由不能为空',
            'route.route' => '路由只能是路由别名,http,https',
        ];
    }


}
