<?php

namespace App\Canteen\Controllers;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('canteen::auth.login');
    }

    public function loginPut()
    {
        dd(1);
//        $credentials = $request->only(['email', 'password']);
//
//        if (Auth::guard('forum')->attempt($credentials)) {
//            return (new JsonResponse())->success('登录成功');
//        } else {
//            throw new LogicException(1010002, [['邮箱或密码错误']]);
//        }
    }

    public function logout(Request $request)
    {
        Auth::guard('forum')->logout();

        $request->session()->invalidate();

        return redirect()->route('f.home');
    }


    public function registerPut(RegisterUserRequest $request)
    {
        if(UsersBls::createUser($request)) {

            $credentials = $request->only(['email', 'password']);
            Auth::guard('forum')->attempt($credentials);

            return (new JsonResponse())->success('注册成功');
        } else {
            throw new LogicException(1010002, [['注册失败']]);
        }

    }
}
