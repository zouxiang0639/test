<?php

namespace App\Admin\Controllers\Other;

use App\Admin\Bls\Other\FeedbackBls;
use App\Admin\Bls\Other\FeedbackStrategy\FeedbackStrategy;
use App\Admin\Bls\Other\Traits\FeedbackTraits;
use App\Consts\Admin\Other\FeedbackTypeConst;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use View;

/**
 * Created by FeedbackController.
 * @author: zouxiang
 * @date:
 */
class FeedbackController extends Controller
{
    use FeedbackTraits;

    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if(empty($request->type)) {
            $request->merge(['type' => FeedbackTypeConst::ALL]);
        }

        $list = FeedbackBls::getFeedbackList($request);

        $this->formatFeedback($list->getCollection());


        return View::make('admin::other.feedback.index',[
            'list' => $list,
            'type' => FeedbackTypeConst::desc()
        ]);
    }

    public function show($id)
    {
        $model = FeedbackBls::find($id);
        $this->isEmpty($model);

        $this->formatFeedback(Collection::make([$model]));
        $extend = (new FeedbackStrategy($model->type))->show($model);

        return View::make('admin::other.feedback.show',[
            'info' => $model,
            'extend' => $extend
        ]);
    }
}
