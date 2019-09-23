<?php

namespace App\Modules\Adminx\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Adminx\Models\gridComponent\UserxGenerator;
use App\Modules\Adminx\Models\Userx;
use Illuminate\Support\Facades\Validator;

class UserxController extends MainController
{

    public function index()
    {
        $r=1;

        $params = [
            'gridxId' => 'userxGrid',
            'modelClass' => 'App\Modules\Adminx\Models\Userx',
            'filterView' => 'Adminx::userx._filter_userx',
            'pagination' => 6,
            'tableOptions' => [
                'class' => 'table table-bordered table-hover table-condensed',
                'style' => ' width: 100%; table-layout: fixed;',
            ],
            'columns' => [
                [
                    'attribute'=>'id',
                    'draw' => 'no',
                ],
                [
                    'attribute'=>'name',
                ],
                [
                    'attribute'=>'email',
                    'contentOptions' => [
                        'style' => 'color: brown;'
                    ],
                    'content'=>function($data){
                        $r=1;
                        return (isset($data->email)) ? $data->email . '__qwerty' : '';
                    },
                ],
                [
                    'attribute'=>'control',
                    'label'=>'',
                    'content'=>function($data){
                        $ret='<a class="btn btn-primary" href="userx/update/' . $data->id . '">Update</a>';
                        return $ret;
                    },
                ],
            ],
            'sortOptions' => [
              'name' => [
                  'asc' => 'name',
                  'desc' => 'name',
              ],
              'email' => [
                  'asc' => 'email',
                  'desc' => 'email',
              ],
            ],
        ];

        $requestParams = $this->requestx->all();
        $generator = new UserxGenerator($params, $requestParams);

        if ($this->requestx->ajax()){
            $ret = $generator->getGridRefreshData();
            return json_encode($ret);
        } else {
            $w=1;
            return view('Adminx::userx.index',[
                'generator' => $generator,
            ]);
        }


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