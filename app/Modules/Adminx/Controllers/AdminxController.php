<?php

namespace App\Modules\Adminx\Controllers;

use App\Http\Controllers\Controller;

class AdminxController extends Controller
{

    public function index()
    {
        return view('Adminx::user.user');
    }

}