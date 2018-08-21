<?php
namespace App\Library\Validators;

use App\Exceptions\LogicException;
use App\Library\Response\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Ajax请求验证器
 */
class JsonResponseApiRequests extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        die((new JsonResponse())->error('1010001', '参数错误', $this->formatErrors($validator), false));
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