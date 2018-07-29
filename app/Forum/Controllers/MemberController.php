<?php

namespace App\Forum\Controllers;

use App\Http\Controllers\Controller;

class MemberController extends Controller
{

    public function index()
    {
        return view('forum::member.index');
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
