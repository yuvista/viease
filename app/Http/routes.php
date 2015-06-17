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
            'namespace'  => 'Admin'
         ];

Route::group($admin, function(){

    //我的公众号列表页
    Route::get('/', 'AccountController@getManage');
    Route::get('table', 'PageController@getDivTable');
    Route::controller('auth', 'AuthController');
    // Route::controller('user', 'UserController');
    Route::controller('fan', 'FanController');
    Route::controller('fan-group', 'FanGroupController');
    Route::controller('account', 'AccountController');
    //demo
    Route::get('demo','PageController@getDemo');

    //所有需要公众号操作的控制 请写到这里
    Route::group(['middleware' => 'account'],function(){

        //消息
        Route::group(['prefix' => 'message', 'namespace' => 'Message'],function(){

            Route::controller('message-timeline', 'MessageTimeLineController');
            Route::controller('broadcasting', 'BroadcastingController');
            Route::controller('resource', 'ResourceController');
            Route::controller('notice', 'NoticeController');
        });

        //素材管理
        Route::group(['prefix' => 'material', 'namespace' => 'Material'],function(){

            Route::controller('article', 'ArticleController');
            Route::controller('material', 'MaterialController');
        });

        //账号与服务
        Route::group(['prefix' => 'services' ,'namespace' => 'Services'],function(){

            Route::controller('menu',　'MenuController');
            Route::controller('auto-reply', 'AutoReplyController');
            Route::controller('follow-reply', 'FollowReplyController');

        });

        //数据统计
        Route::group(['prefix' => 'data', 'namespace' => 'Data'],function(){


        });
    });
});