<?php
    Route::group( [
        'namespace' => 'App\Modules\Test\Controllers',
        'as' => 'test.',
        ], function(){
            Route::get('/test', ['uses' => 'TestController@index']);
    });
