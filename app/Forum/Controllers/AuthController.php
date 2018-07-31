<?php

namespace App\Forum\Controllers;

use App\Exceptions\LogicException;
use App\Forum\Bls\Users\Requests\LoginUserRequest;
use App\Forum\Bls\Users\Requests\RegisterUserRequest;
use App\Forum\Bls\Users\UsersBls;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function login()
    {
        return view('forum::auth.login');
    }

    public function loginPut(LoginUserRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::guard('forum')->attempt($credentials)) {
            $user = Auth::guard('forum')->user();
            $user->login_num ++;
            $user->save();

            return (new JsonResponse())->success('登录成功');
        } else {
            throw new LogicException(1010002, [['邮箱或密码错误']]);
        }
    }

    public function register()
    {
        return view('forum::auth.register');
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

    public function qq()
    {
        return Socialite::with('qq')->redirect();
    }

    public function weibo()
    {
        return Socialite::with('weibo')->redirect();
    }


}
