<?php

namespace App\Widgets\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class GridxController extends Controller
{
    protected $requestx;

    public function __construct(Request $request)
    {
        $this->requestx = $request;
    }
    public function getHeader()
    {
        $r=1;
        /*
        $session = app('session');
        if (isset($session)) {
            return $session->token();
        }
        */
      /*  $view=view('Widgets::gridx.header');
        $view=$view->render();
        $responseData->responseSuccess($view);
      */
        return view('Widgets::gridx.header',[
        ]);
    }
}