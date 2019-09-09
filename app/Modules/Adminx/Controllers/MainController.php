<?php

namespace App\Modules\Adminx\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class MainController extends Controller
{
    protected $requestx;

    public function __construct(Request $request)
    {
        $r=1;
        $this->requestx = $request;
    }

}