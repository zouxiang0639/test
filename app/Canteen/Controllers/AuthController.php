<?php

namespace App\Canteen\Controllers;

use App\Canteen\Bls\Users\Requests\LoginUserRequest;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('canteen')->check()) {
            return redirect()->route('c.member');
        }

        return view('canteen::auth.login');
    }

    public function loginPut(LoginUserRequest $request)
    {
        $credentials = $request->only(['mobile', 'password']);

        if (Auth::guard('canteen')->attempt($credentials)) {
            return (new JsonResponse())->success('登录成功');
        } else {
            throw new LogicException(1010002, '手机号或密码错误');
        }
    }

    public function logout(Request $request)
    {

        Auth::guard('canteen')->logout();

        $request->session()->invalidate();

        return redirect()->route('c.auth.login');
    }

}
