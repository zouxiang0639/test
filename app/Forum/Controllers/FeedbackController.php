<?php

namespace App\Forum\Controllers;

use App\Admin\Bls\Other\Requests\FeedbackRequests;
use App\Consts\Admin\Other\FeedbackTypeConst;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function feedback()
    {

        $info = [
            'title' => FeedbackTypeConst::FEEDBACK_DESC,
            'type' => FeedbackTypeConst::FEEDBACK
        ];

        return view('forum::feedback.feedback', [
            'info' => $info
        ]);
    }

    public function store(FeedbackRequests $requests)
    {
        dd(1);
    }
}
