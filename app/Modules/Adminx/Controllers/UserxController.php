<?php

namespace App\Modules\Adminx\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Adminx\Models\Userx;
use Illuminate\Support\Facades\Validator;

class UserxController extends MainController
{

    public function index()
    {
        $users = Userx::orderBy('created_at', 'asc')->get();
        return view('Adminx::userx.index',[
            'users' => $users,
        ]);
    }

    public function update($id=0)
    {
        $r=1;
        if (($id == 0)){
            $user = new Userx();
            $actionRoute = url('/adminx/userx/update/0');
        } else {
            $user = Userx::find($id);
            $actionRoute = url('/adminx/userx/update/' . $user->id);
        }
        if ($this->requestx->method() === 'POST') {
            $validator = Validator::make($this->requestx->all(), [
                'name' => 'required|max:255',
                'email' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect('/adminx/userx/create')
                    ->withInput()
                    ->withErrors($validator);
            }

            //$user = new Userx();
            $user->name = $this->requestx->name;
            $user->email = $this->requestx->email;
            $user->password = '12345';
            $user->save();

            return redirect('/adminx/userx');
        }
        return view('Adminx::userx.update', [
            'user' => $user,
            'actionRoute' => $actionRoute,
        ]);
    }

    public function delete($id)
    {
        $r = $this->requestx;
        $user = Userx::find($id);
        if ($this->requestx->method() === 'DELETE'){
            $ret = $user->delete();
            return redirect('/adminx/userx');
        }

        return view('Adminx::userx.delete_confirm', [
            'user' => $user,
        ]);

    }

}