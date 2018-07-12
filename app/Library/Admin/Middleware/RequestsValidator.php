<?php

namespace App\Library\Admin\Middleware;

use Closure;
use Validator;
use Input;

class RequestsValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Validator::extend('array_required', function ($attribute, $value, $parameters, $validator) {
            return true;
        });
        return $next($request);
    }
}
