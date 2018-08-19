<?php
namespace App\Library\Validators;

use App\Exceptions\LogicException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Ajax请求验证器
 */
class JsonResponseRequests extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new LogicException(1010001, $this->formatErrors($validator));
    }

    /**
     * Authorize.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }
}