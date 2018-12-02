<?php

namespace App\H5\Controllers;

use App\Forum\Bls\Article\ArticleBls;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Forum;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if(empty($request->type)) {
            $request->merge(['type' => 'hot']);
        }

        $list = ArticleBls::getArticleLise($request);
        $this->formatData($list->getCollection());

        return view('h5::home.index', [
            'list' => $list,
        ]);
    }

    protected function formatData(Collection $item)
    {
        $item->each(function($item) {
            $item->replyCount = $item->reply()->count();
        });
    }

}
