<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * Admin
 */
$admin = [
            'prefix'     => 'admin',
            'namespace'  => 'Admin'
         ];

Route::group($admin, function(){

    //我的公众号列表页
    Route::get('/', 'PageController@getIndex');
    Route::get('table','PageController@getDivTable');
    Route::controller('account','AccountController');
    Route::controller('auth', 'AuthController');
    // Route::controller('user', 'UserController');
    Route::controller('fan', 'FanController');
    Route::controller('fan-group', 'FanGroupController');
    //demo
    Route::get('demo','PageController@getDemo');
});