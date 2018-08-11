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
    return '深圳静界科技有限公司';
});

/**
 * 定位数据
 */
Route::group(['namespace'=>'Location','prefix'=>'location'], function () {
    //Datasky
    Route::any('/datasky', 'DataskyController@index');
});

/**
 * 管理后台
 */
Route::group(['namespace'=>'Admin', 'prefix'=>'admin'], function () {
    //登录界面
    Route::get('/login', 'LoginController@index');
    //登录验证
    Route::post('/logindata', 'LoginController@login');
    //首页
    Route::get('/index', 'IndexController@index');
    //获取坐标列表
    Route::get('/getcoordinate', 'CoordinateController@get');
    //坐标显示
    Route::any('/show', 'IndexController@show');
    //坐标轨迹
    Route::any('/getshow', 'CoordinateController@one');
    //MAC绑定
    Route::get('/bind', 'IndexController@bind');
    //指定MAC坐标返回
    Route::any('/getbinds', 'CoordinateController@bind');
});

//定时任务
Route::group(['namespace'=>'Crontab', 'prefix'=>'crontab'], function () {
    //存入数据库队列
    Route::get('/todb', 'DataskyController@xy_to_db');
    //计算XY队列
    Route::get('/toxy', 'DataskyController@list_to_xy');
});
