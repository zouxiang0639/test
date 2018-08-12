<?php

namespace App\Canteen\Controllers;

use App\Canteen\Bls\Users\AccountFlowBls;
use App\Consts\Common\AccountFlowTypeConst;
use App\Http\Controllers\Controller;
use App\Library\Format\FormatMoney;
use Endroid\QrCode\QrCode;
use Auth;

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
        $qrCode = new QrCode('Life is too short to be generating QR codes');
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
    }

    public function flow()
    {
        $list = AccountFlowBls::gitAccountFlowList();

        $list->getCollection()->each(function($item) {
            $typeIconName = AccountFlowTypeConst::geticonDesc($item->type);
            $item->formatCreatedAt = mb_substr($item->created_at, 0, 10);
            $item->formatAmount = $typeIconName.FormatMoney::fen2yuan($item->amount);
            $item->typeName = AccountFlowTypeConst::getDesc($item->type);

        });

        return view('canteen::member.flow', [
            'list' => $list
        ]);
    }
}
