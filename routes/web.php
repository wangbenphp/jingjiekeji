<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/test', 'Test\IndexController@index');

Route::get('/chuli', 'Test\IndexController@chuli');

Route::post('/setting', 'Test\IndexController@setting');

/**
 * 微信路由
 */
Route::group(['namespace'=>'Wechat','prefix'=>'wechat'], function () {
    //微信公众号入口
    Route::any('/index', 'IndexController@index');
    //微信授权
    Route::any('/auth', 'IndexController@auth');
    //分享路由
    Route::group(['prefix' => 'share'], function () {
        Route::get('/index', 'ShareController@index');
    });
});

/**
 * 管理后台
 */
Route::group(['namespace'=>'Admin','prefix'=>'admin'], function () {
    //登录界面
    Route::get('/login', 'LoginController@index');
    //登录验证
    Route::post('/logindata', 'LoginController@login');
});
