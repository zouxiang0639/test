<?php

namespace App\Canteen\Controllers;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('canteen::order.index');
    }


}
