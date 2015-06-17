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

Route::get('/', 'ServerController@server');
Route::post('/', 'ServerController@server');

/**
 * Admin
 */
$admin = [
            'prefix'     => 'admin',
            'namespace'  => 'Admin',
         ];

Route::group($admin, function(){

    Route::get('/', 'AccountController@getManage');
    Route::group(['middleware' => 'account'],function(){

        Route::controllers([
            'auth'             => 'AuthController',
            'user'             => 'UserController',
            'fan'              => 'FanController',
            'fan-group'        => 'FanGroupController',
            'account'          => 'AccountController',
            'menu'             => 'MenuController',
            'material'         => 'MaterialController',
            'material/article' => 'ArticleController',
            'analysis'         => 'AnalysisController',
            'staff'            => 'StaffController',
            'tool'             => 'ToolController',
            'message'          => 'MessageController',
            'notice'           => 'NoticeController',
            'auto-reply'       => 'AutoReplyController',
        ]);
    });
});