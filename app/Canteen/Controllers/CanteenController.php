<?php

namespace App\Canteen\Controllers;

use App\Exceptions\LogicException;
use App\Http\Controllers\Controller;
use App\Library\Response\JsonResponse;
use Auth;
use Illuminate\Http\Request;

class CanteenController extends Controller
{
    public function takeout()
    {
        return view('canteen::canteen.takeout');
    }

    public function meal()
    {
        return view('canteen::canteen.meal');
    }
}
