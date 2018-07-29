<?php

namespace App\Forum\Controllers;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index($id)
    {
        return view('forum::article.index');
    }

    public function create()
    {
        return view('forum::article.create');
    }

    public function info()
    {

    }
}
