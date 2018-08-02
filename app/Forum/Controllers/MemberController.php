<?php

namespace App\Forum\Controllers;

use App\Http\Controllers\Controller;

class MemberController extends Controller
{

    public function index()
    {
        $info = \Auth::guard('forum')->user();
        return view('forum::member.index', [
            'info' => $info,
        ]);
    }

    public function login()
    {
        return view('forum::member.login');
    }

    public function register()
    {
        return view('forum::member.register');
    }

    public function info()
    {
        return view('forum::member.info');
    }

    public function reply()
    {
        return view('forum::member.reply');
    }
}
