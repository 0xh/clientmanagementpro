<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api'
], function () {
        Route::get('/auth/user', function(){
        if(auth()->check()){
            return auth()->user();
        }
        return 'no auth user';
    });
    Route::get('/auth/employee', function(){
        if(auth()->guard('employee')->check()){
            return auth()->guard('employee')->user();
        }
        return 'no auth user';
    });
    Route::get('/auth/client', function(){
        if(auth()->guard('client')->check()){
            return auth()->guard('employee')->user();
        }
        return 'no auth user';
    });
});
