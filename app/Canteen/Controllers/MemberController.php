<?php

namespace App\Canteen\Controllers;

use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;

class MemberController extends Controller
{
    public function index()
    {
        return view('canteen::member.index');
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
}
