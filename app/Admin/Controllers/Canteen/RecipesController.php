<?php

namespace App\Admin\Controllers\Canteen;

use App\Admin\Bls\Canteen\Requests\RecipesRequest;
use App\Admin\Bls\Canteen\RecipesBls;
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
class RecipesController extends Controller
{
    use TakeoutTraits;

    /**
     * 食谱列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $list = RecipesBls::getTakeoutList($request);

        $this->formatTakeout($list->getCollection());

        return View::make('admin::canteen.recipes.index',[
            'list' => $list,
            'takeoutDeadlineCheck' => date('Y-m-d') <= config('config.takeout_deadline')
        ]);
    }

    /**
     * 创建食谱
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('admin::canteen.recipes.create',[
            'form' =>  $this->form([])
        ]);
    }


    /**
     * 存储食谱
     * @param RecipesRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function store(RecipesRequest $request)
    {
        if(RecipesBls::storeTakeout($request)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 编辑食谱
     * @param $id
     * @return \Illuminate\Contracts\View\View
     * @throws LogicException
     */
    public function edit($id)
    {
        $model = RecipesBls::find($id);

        $this->isEmpty($model);
        $this->formatTakeout(Collection::make([$model]));

        return View::make('admin::canteen.recipes.edit',[
            'form' =>  $this->form($model),
            'info' => $model
        ]);
    }

    /**
     * 更新食谱
     * @param RecipesRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function update(RecipesRequest $request, $id)
    {
        $model = RecipesBls::find($id);

        $this->isEmpty($model);

        if(RecipesBls::updateTakeout($request, $model)) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, '操作失败');
        }
    }

    /**
     * 修改食谱状态
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function status($id, Request $request)
    {

        $this->isEmpty(WhetherConst::getDesc($request->status));

        $model = RecipesBls::find($id);

        $this->isEmpty($model);

        $model->status = $request->status;

        if($model->save()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }
    }

    /**
     * 删除食谱
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws LogicException
     */
    public function destroy($id)
    {
        $model = RecipesBls::find($id);

        $this->isEmpty($model);

        if($model->delete()) {
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010001, '操作失败');
        }

    }


    /**
     * 食谱表单
     * @param $info
     * @return string
     */
    public function form($info)
    {
        return Admin::form(function(Forms $item) use($info) {

            $item->create('就餐日期', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->datetime('date', array_get($info, 'date'), $h->options, 'YYYY-MM-DD');
                $h->set('date', true);
            });

            $item->create('早餐', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('morning', array_get($info, 'morning'), $h->options);
                $h->set('morning', true);
            });

            $item->create('午餐', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('lunch', array_get($info, 'lunch'), $h->options);
                $h->set('lunch', true);
            });

            $item->create('晚餐', function(HtmlFormTpl $h, FormBuilder $form) use ($info){
                $h->input = $form->textarea('dinner', array_get($info, 'dinner'), $h->options);
                $h->set('dinner', true);
            });

        })->getFormHtml();

    }

}
