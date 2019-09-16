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
//接口curd方法
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
//接口curd 搜索分页带前端样式 restful风格
/**
 * restful
 *  API设计理念：URL定位资源，用HTTP动词（GET,POST,DELETE,DETC）描述操作
 *
 * --restful需要去除csrf 不必担心接口安全问题 (cdrf是身份伪造 而restful无法传输cookie、session等包含身份的信息 所以不必考虑)  一般是前后端分离或者支付宝响应的时候需要不设置csrfToken校验的接口,laravel推荐使用passport安全校验设计接口 csrf要借助浏览器来攻击，restful不用浏览器。
 */
Route::resource('api/user/restful','Api\UserRestfulController');


//签名算法设计
Route::get('api/sign','Api\SignController@index');


//form-data文件上传视图
Route::get('api/upload_view','Upload\UploadController@upload_view');
//二进制文件上传视图
Route::get('api/upload_binary_view','Upload\UploadController@upload_binary_view');
//Base64文件上传视图
Route::get('api/upload_Base64_view','Upload\UploadController@upload_Base64_view');
//执行form-data文件上传
Route::POST('api/upload','Upload\UploadController@upload');
//执行二进制文件上传
Route::POST('api/upload_binary','Upload\UploadController@upload_binary');
//执行Base64文件上传
Route::POST('api/upload_Base64','Upload\UploadController@upload_Base64');

//商品管理
//接口添加视图
Route::get('goods/add',function(){
    return view('admin.goods.add');
});
//接口展示视图
Route::get('/goods/goods_list',function(){
    return view('admin.goods.index');
});
//修改查询
Route::get('/goods/find',function(){
    return view('admin.goods.find');
});
Route::resource('api/goods/restful','Api\GoodsController');


//凯撒加密
Route::get('api/encrypt/caesa r','Encrypt\EncryptController@index');

//AES加密
Route::get('api/encrypt/aes','Encrypt\AesController@aes_running');
//自己测的Aes加密接口
Route::get('api/encrypt/Aes_self_encrypt','Encrypt\AesController@Aes_self_encrypt');

//Rsa加密
Route::get('api/encrypt/rsa','Encrypt\RsaController@Rsa_running');



//商城项目

//分类添加
//分类展示视图
Route::get('admin/goods/cate_list',function(){
    return view('admin.new_goods.category.cate_list');
});
Route::get("admin/goods/cate_add","Admin\CategoryController@add");
Route::POST("admin/goods/cate_do_add","Admin\CategoryController@do_add");
Route::get("admin/goods/cate_index","Admin\CategoryController@index");


//类型添加
//类型展示视图
Route::get('admin/goods/type_list',function(){
    return view('admin.new_goods.type.type_list');
});
Route::get("admin/goods/type_add","Admin\TypeController@add");
Route::POST("admin/goods/type_do_add","Admin\TypeController@do_add");
Route::get("admin/goods/type_index","Admin\TypeController@index");

//属性添加
//属性展示视图
Route::get('admin/goods/attr_list',function(){
    return view('admin.new_goods.attribute.attr_list');
});
Route::get("admin/goods/attr_add","Admin\AttributeController@add");
Route::POST("admin/goods/attr_do_add","Admin\AttributeController@do_add");
Route::get("admin/goods/attr_index","Admin\AttributeController@index");

//商品添加页面
Route::get("admin/goods/goods_add","Admin\Goods_controller@add");
//查询属性
Route::get("admin/goods/getAttr","Admin\Goods_controller@getAttr");