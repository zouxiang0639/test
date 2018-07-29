<?php

namespace App\Forum\Controllers;

use App\Forum\Bls\Users\Requests\RegisterUserRequest;
use App\Forum\Bls\Users\UsersBls;
use App\Http\Controllers\Controller;
use Auth;

class AuthController extends Controller
{

    public function login()
    {
        return view('forum::auth.login');
    }

    public function register()
    {
        return view('forum::auth.register');
    }

    public function registerPut(RegisterUserRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        Auth::guard('forum')->attempt($credentials);
        if(UsersBls::createUser($request)) {

        }

    }


}
