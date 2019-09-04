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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/','wjl\ceshi@index');
//测试 curl get post 封装在一个方法中 自己写的不成熟
Route::get('/test','get_post_controller@test');
//测试 curl get post 原始数据xml、json
Route::get('/test_1','get_post_controller@test_1');
//接口：：获取用户列表
Route::get('/wechat_openid','get_post_controller@wechat_openid');
//测试 file_get_contents get post请求方式
Route::get('/file_get_contents_get_post','get_post_controller@file_get_contents_get_post');


/**
 * 接口curd 【前后端分离】
 */

//接口添加视图
Route::get('user/add',function(){
    return view('user/add');
});
//接口展示视图
Route::get('/user/user_list',function(){
    return view('user/user_list');
});
//修改查询视图
Route::get('/user/find',function(){
    return view('user/find');
});


Route::prefix('api/user')->group(function() {
    //用户接口列表
    Route::get('/user_list','Api\userController@user_list');
    //用户接口添加
    Route::get('/user_add','Api\userController@add');
    //用户接口删除
    Route::get('/user_del','Api\userController@del');
    //修改查询用户信息
    Route::get('/find','Api\userController@find');
    //执行修改
    Route::get('/save','Api\userController@save');
});


/**
 * restful
 *  API设计理念：URL定位资源，用HTTP动词（GET,POST,DELETE,DETC）描述操作
 *
 * --restful需要去除csrf 不必担心接口安全问题 (cdrf是身份伪造 而restful无法传输cookie、session等包含身份的信息 所以不必考虑)  一般是前后端分离或者支付宝响应的时候需要不设置csrfToken校验的接口,laravel推荐使用passport安全校验设计接口 csrf要借助浏览器来攻击，restful不用浏览器。
 */

Route::resource('api/user/restful','Api\UserRestfulController');