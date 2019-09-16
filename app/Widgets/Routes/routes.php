<?php
    Route::group( [
        'namespace' => 'App\Widgets\Controllers',
        'as' => 'widgets.',
        'middleware' => 'web',
        ], function(){
            Route::get('/gridx/get_header', ['uses' => 'GridxController@getHeader']);
            Route::post('/gridx/get_header', ['uses' => 'GridxController@getHeader']);
    });
