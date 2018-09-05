<?php

namespace App\Forum\Controllers;

use App\Admin\Bls\Other\FeedbackBls;
use App\Admin\Bls\Other\FeedbackStrategy\FeedbackStrategy;
use App\Admin\Bls\Other\Requests\FeedbackRequests;
use App\Consts\Admin\Other\FeedbackTypeConst;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;

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

    public function operate()
    {

        $info = [
            'title' => FeedbackTypeConst::OPERATE_DESC,
            'type' => FeedbackTypeConst::OPERATE
        ];

        return view('forum::feedback.feedback', [
            'info' => $info
        ]);
    }

    public function moderator()
    {

        $info = [
            'title' => FeedbackTypeConst::MODERATOR_DESC,
            'type' => FeedbackTypeConst::MODERATOR
        ];

        return view('forum::feedback.feedback', [
            'info' => $info
        ]);
    }

    public function appeals()
    {

        $info = [
            'title' => FeedbackTypeConst::APPEALS_DESC,
            'type' => FeedbackTypeConst::APPEALS
        ];

        return view('forum::feedback.feedback', [
            'info' => $info
        ]);
    }



    public function store(FeedbackRequests $requests)
    {
        $extend = (new FeedbackStrategy($requests->type))->store($requests);
        $extend['users_id'] =  $user = Auth::guard('forum')->id();
        $requests->merge($extend);
        if(FeedbackBls::storeFeedback($requests)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, [['操作失败']]);
        }

    }
}
