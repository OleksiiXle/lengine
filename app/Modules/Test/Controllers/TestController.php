<?php

namespace App\Modules\Test\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller
{

    public function index()
    {
        return view('Test::index');
    }

}