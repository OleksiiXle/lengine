<?php

namespace App\Modules\Adminx\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Adminx\Models\Userx;
use App\Modules\Adminx\Requests\SaveUserRequest;
use Illuminate\Support\Facades\Validator;

class UserxController extends MainController
{

    public function index()
    {
        $users = Userx::orderBy('created_at', 'asc')->paginate(15);
        $r = $users->render();
        $r = $users->toHtml();// $users->getUrlRange(1,5)
        $r = $users->items();
        return view('Adminx::userx.index',[
            'users' => $users,
        ]);
    }

    public function update($id=0)
    {
        $r=1;
      //  $r = Sess::get('error');
        if (($id == 0)){
            $user = new Userx();
            $user->setScenario('createByAdmin');
            $actionRoute = url('/adminx/userx/update/0');
        } else {
            $user = Userx::find($id);
            $user->setScenario('updateByAdmin');
            $actionRoute = url('/adminx/userx/update/' . $user->id);
        }
        if ($this->requestx->method() === 'POST') {
            /*
            $this->validate($this->requestx, [
                'title' => 'required|unique|max:255',
                'body' => 'required',
            ]);
*/

            $validator = Validator::make($this->requestx->all(), $user->rules);

            if ($validator->fails()) {
                return redirect('/adminx/userx/update')
                    ->withInput()
                    ->withErrors($validator);
            }

            $user->fill($this->requestx->all());
            $user->password = '12345';

            //$user = new Userx();
            /*
            $user->name = $this->requestx->name;
            $user->email = $this->requestx->email;
            $user->password = '12345';
            */
            if ($user->save()){
                return redirect('/adminx/userx');
            } else {
                $this->requestx->session()->flash('error', $user->exeptionMessage);
                return back();
            }
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