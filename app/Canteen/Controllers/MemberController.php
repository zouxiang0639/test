<?php

namespace App\Canteen\Controllers;

use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index()
    {
        return view('canteen::member.index');
    }
}
