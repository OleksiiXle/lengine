<?php
    Route::group( [
        'namespace' => 'App\Modules\Adminx\Controllers',
        'as' => 'adminx.',
        'middleware' => 'web',
        ], function(){
            Route::get('/adminx', ['uses' => 'AdminxController@index']);
            Route::get('/adminx/userx', ['uses' => 'UserxController@index']);
            Route::post('/adminx/userx', ['uses' => 'UserxController@index']);
            Route::get('/adminx/userx/update/{id}', ['uses' => 'UserxController@update']);
            Route::post('/adminx/userx/update/{id}', ['uses' => 'UserxController@update']);
            Route::get('/adminx/userx/delete/{id}', ['uses' => 'UserxController@delete']);
            Route::post('/adminx/userx/delete/{id}', ['uses' => 'UserxController@delete']);
            Route::delete('/adminx/userx/delete/{id}', ['uses' => 'UserxController@delete']);

    });
