<?php

namespace App\Forum\Controllers;

use App\Forum\Bls\Article\ArticleBls;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $request = new Request();
        $request->type = 'hot';
        $hot = ArticleBls::getArticleLise($request, '', 14);
        $hot->getCollection()->each(function($item) {
            $item->replyCount = $item->reply()->count();
        });
        return view('forum::home.index', [
            'hot' => $hot
        ]);
    }
}
