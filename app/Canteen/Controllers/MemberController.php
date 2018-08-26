<?php

namespace App\Canteen\Controllers;

use App\Canteen\Bls\Users\AccountFlowBls;
use App\Canteen\Bls\Users\Requests\SetupRequest;
use App\Consts\Common\AccountFlowTypeConst;
use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Admin\Widgets\Security;
use App\Library\Format\FormatMoney;
use App\Library\Response\JsonResponse;
use Endroid\QrCode\QrCode;
use Auth;
use Hash;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $model = Auth::guard('canteen')->user();
        return view('canteen::member.index', [
            'info' => $model
        ]);
    }

    /**
     * 会员二维码
     */
    public function qrCode()
    {
        $model = Auth::guard('canteen')->user();
        $data = json_encode([
            'mobile' => $model->mobile,
            'time' => date("Y-m-d H:i:s")
        ]);
        $key = Security::key();
        $string = Security::encrypt($data, $key);
        $qrCode = new QrCode($string);
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
    }


    /**
     * liu流水
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function flow(Request $request)
    {
        $list = AccountFlowBls::gitAccountFlowList();

        $list->getCollection()->each(function($item) {
            $typeIconName = AccountFlowTypeConst::geticonDesc($item->type);
            $item->formatCreatedAt = mb_substr($item->created_at, 0, 10);
            $item->formatAmount = $typeIconName.FormatMoney::fen2yuan($item->amount);
            $item->typeName = AccountFlowTypeConst::getDesc($item->type);

        });

        if($request->ajax()) {
            $view = view('canteen::member.flow_ajax',['list' => $list])->render();
            return (new JsonResponse())->success($view);
        }

        return view('canteen::member.flow', [
            'list' => $list
        ]);
    }

    public function setup()
    {

        $model = Auth::guard('canteen')->user();
        return view('canteen::member.setup', [
            'info' => $model
        ]);
    }

    public function settingPassword(SetupRequest $request)
    {
        $model = Auth::guard('canteen')->user();

        if(!Hash::check($request->old_password, $model->password)){
            throw new LogicException(1010001, [['原始密码错误']]);
        }
        $model->password = bcrypt($request->password);

        if($model->save()){
            return (new JsonResponse())->success('操作成功');
        } else {
            throw new LogicException(1010002, [['操作失败']]);
        }

    }
}
