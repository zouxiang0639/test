<?php

namespace App\Admin\Controllers\Canteen;

use App\Admin\Bls\Canteen\Requests\TakeoutRequest;
use App\Admin\Bls\Canteen\TakeoutBls;
use App\Admin\Bls\Canteen\Traits\TakeoutTraits;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use Admin;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use View;

/**
 * Created by TakeoutController.
 * @author: zouxiang
 * @date:
 */
class TakeoutController extends Controller
{
    use TakeoutTraits;

    /**
     * 外卖列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $list = TakeoutBls::getTakeoutList($request);

        $this->formatTakeout($list->getCollection());

        return View::make('admin::canteen.takeout.index',[
            'list' => $list,
            'takeoutDeadlineCheck' => date('Y-m-d') <= config('config.takeout_deadline')
        ]);
    }

    /**
     * 创建外卖
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('admin::canteen.takeout.create',[
            'form' =>  $this->form([])
        ]);
    }


    /**
     * 存储外卖
     * @param TakeoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(TakeoutRequest $request)
    {
        if(TakeoutBls::storeTakeout($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 编辑外卖
     * @param $id
     * @return \Illuminate\Contracts\View\View
     * @throws LogicException
     */
    public function edit($id)
    {
        $model = TakeoutBls::find($id);

        $this->isEmpty($model);
        $this->formatTakeout(Collection::make([$model]));

        return View::make('admin::canteen.takeout.edit',[
            'form' =>  $this->form($model),
            'info' => $model
        ]);
    }

    /**
     * 更新外卖
     * @param TakeoutRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(TakeoutRequest $request, $id)
    {
        $model = TakeoutBls::find($id);

        $this->isEmpty($model);

        if(TakeoutBls::updateTakeout($request, $model)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 修改外卖状态
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function status($id, Request $request)
    {

        $this->isEmpty(WhetherConst::getDesc($request->status));

        $model = TakeoutBls::find($id);

        $this->isEmpty($model);

        $model->status = $request->status;

        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    /**
     * 删除外卖
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($id)
    {
        $model = TakeoutBls::find($id);

        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }

    }


    /**
     * 外卖表单
     * @param $info
     * @return string
     */
    public function form($info)
    {
        return Admin::form(function(Forms $item) use($info) {

            $item->create('状态', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->switchOff('status', array_get($info, 'status', WhetherConst::NO));
                $h->set('status', true);
            });

            $item->create('是否称重', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->switchOff('is_weigh', array_get($info, 'is_weigh', WhetherConst::NO));
                $h->set('is_weigh', true);
            });

            $item->create('外卖名称', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->text('title', array_get($info, 'title'), $h->options);
                $h->set('title', true);
            });

            $item->create('库存', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->number('stock', array_get($info, 'stock', 0), $h->options);
                $h->set('stock', true);
            });

            $item->create('每个人限购', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->number('limit', array_get($info, 'limit', 0), $h->options);
                $h->set('limit', true);
            });

            $item->create('价格', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->currency('price', array_get($info, 'price', 0), $h->options);
                $h->set('price', true);
            });

            $item->create('定金', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->currency('deposit', array_get($info, 'deposit', 0), $h->options);
                $h->set('deposit', true);
            });

            $item->create('图片', function(HtmlFormTpl $h, FormBuilder $form) use($info) {
                $h->input = $form->imageOne('picture', array_get($info, 'picture'), $h->options);
                $h->set('picture', true);
            });

            $item->create('描述', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('describe', array_get($info, 'describe'), $h->options);
                $h->set('describe', false);
            });

        })->getFormHtml();

    }

}
