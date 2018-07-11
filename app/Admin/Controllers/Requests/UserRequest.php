<?php

namespace App\Admin\Controllers\Requests;

use App\Library\Validators\JsonResponseValidator;

class UserRequest extends JsonResponseValidator
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|unique:posts|max:255',
        ];
    }


}
