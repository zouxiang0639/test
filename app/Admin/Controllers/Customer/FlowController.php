<?php

namespace App\Admin\Controllers\Customer;

use App\Admin\Bls\System\TagsBls;
use App\Canteen\Bls\Users\AccountFlowBls;
use App\Canteen\Bls\Users\UsersBls;
use App\Consts\Admin\Tags\TagsTypeConst;
use App\Consts\Common\AccountFlowTypeConst;
use App\Consts\Common\WhetherConst;
use App\Exceptions\LogicException;
use App\Library\Admin\Form\FormBuilder;
use App\Library\Admin\Form\HtmlFormTpl;
use App\Library\Admin\Widgets\Forms;
use App\Library\Format\FormatMoney;
use App\Library\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Admin;
use View;

/**
 * Created by FlowController.
 * @author: zouxiang
 * @date:
 */
class FlowController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $usersList = UsersBls::usersAll()->pluck('name', 'id')->toArray();
        $model = AccountFlowBls::gitAccountFlow($request);
        $model->getCollection()->each(function($item) use ($usersList) {
            $item->userName = array_get($usersList, $item->user_id);
            $item->formatAmount = AccountFlowTypeConst::getIconDesc($item->type).FormatMoney::fen2yuan($item->amount);
            $item->typeName = AccountFlowTypeConst::getDesc($item->type);
        });

        return View::make('admin::customer.flow.index',[
            'list' => $model,
            'usersList' => $usersList
        ]);
    }
}
