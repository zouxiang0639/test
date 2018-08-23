<?php

namespace App\Api\Controllers;

use App\Api\Bls\Users\Requests\SitePaymentRequests;
use App\Canteen\Bls\Users\UsersBls;
use App\Http\Controllers\ApiController;


class SiteController extends ApiController
{

    /**
     * 现场支付
     * @param SitePaymentRequests $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payment(SitePaymentRequests $request)
    {
        $model = UsersBls::getUsersByMobile($request->mobile);
        if(is_null($model)) {
            return $this->error(1050003);
        }

        //验证支付令牌是否错误
        if($model->remember_token != $request->token) {
            return $this->error(1050005);
        }

        //减去用户金额
        $model->money -= $request->amount;
        if($model->money < 0) {
            return $this->error(1050007);
        }

        if(UsersBls::payment($model, $request)) {
            return $this->success(['money' => $model->money, 'mobile' => $model->mobile]);
        } else {
            return $this->error(1010002);
        }
    }


}
