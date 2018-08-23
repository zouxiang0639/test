<?php

namespace App\Http\Middleware;

use App\Library\Admin\Widgets\Security;
use App\Library\Response\JsonResponse;
use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Aes解密中间件
 * @author: zouxiang
 * @date:
 */
class ApiAes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $date = date('Ymd');
        $key = $date.strrev($date);
        $key = '2018082222808102';

        $data = Security::decrypt($request[$guard], $key);

        if($data == false) {
            die((new JsonResponse())->error('1050002'));
        }

        $data = json_decode($data, true);

        if(!is_array($data)) {
            die((new JsonResponse())->error('1050001'));
        }

        $request->merge($data);
        return $next($request);
    }
}
