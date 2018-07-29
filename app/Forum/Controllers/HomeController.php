<?php

namespace App\Forum\Controllers;

use App\Http\Controllers\Controller;
use Forum;

class HomeController extends Controller
{
    public function index()
    {
        return view('forum::home.index');
    }
}
