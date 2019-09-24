<?php

Route::options('/{all}', function(Request $request) {
    $origin = $request->header('ORIGIN', '*');
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Access-Control-Request-Headers, SERVER_NAME, Access-Control-Allow-Headers, cache-control, token, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');
})->where(['all' => '([a-zA-Z0-9-]|/)+']);
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



//商城后台项目

Route::group(['middleware' => ['check_login_admin'],'prefix'=>'admin/goods'],function () {
    //分类添加
//分类展示视图 (接口做的)
    Route::get('/cate_list',function(){
        return view('admin.new_goods.category.cate_list');
    });
    Route::get("/cate_add","Admin\CategoryController@add");
    Route::POST("/cate_do_add","Admin\CategoryController@do_add");
    Route::get("/cate_index","Admin\CategoryController@index");
//分类名称唯一性验证
    Route::POST("/cate_name_unique_verufy","Admin\CategoryController@cate_name_unique_verufy");


//类型添加
//类型展示视图 (接口做的)
    Route::get('/type_list',function(){
        return view('admin.new_goods.type.type_list');
    });
    Route::get("/type_add","Admin\TypeController@add");
    Route::POST("/type_do_add","Admin\TypeController@do_add");
    Route::get("/type_index","Admin\TypeController@index");

//属性添加
//属性展示视图 (接口做的)
    Route::get('/attr_list',"Admin\AttributeController@attr_list");
    Route::get("/attr_add","Admin\AttributeController@add");
    Route::POST("/attr_do_add","Admin\AttributeController@do_add");
    Route::get("/attr_index","Admin\AttributeController@index");
//属性批量删除
    Route::get("/attr_pishan","Admin\AttributeController@pishan");


//商品添加页面
    Route::get("/goods_add","Admin\Goods_controller@add");
//查询属性 （用于选择商品类型时出现对应的商品属性）
    Route::get("/getAttr","Admin\Goods_controller@getAttr");
//执行商品添加
    Route::POST("/goods_do_add","Admin\Goods_controller@store");
//跳转去库存页面
    Route::get("/goods_sku/{goods_id}","Admin\Goods_controller@sku");
//执行添加sku
    Route::POST("/goods_do_sku","Admin\Goods_controller@sku_do_add");
//商品展示页面
    Route::get("/goods_list","Admin\Goods_controller@goods_list");
//商品展示接口
    Route::get("/goods_index","Admin\Goods_controller@index");
//商品名称即点即改
    Route::get("/goods_jidianjigai","Admin\Goods_controller@goods_jidianjigai");
//商品上架即点即改
    Route::get("/goods_jidianjigai_1","Admin\Goods_controller@goods_jidianjigai_1");

});


//后台普通登录
//登陆页面
Route::get("admin/login","Admin\LoginController@login");
//执行登陆操作
Route::get("admin/do_login","Admin\LoginController@do_login");
//注册页面
Route::get("admin/register","Admin\LoginController@register");
//执行注册操作
Route::get("admin/do_register","Admin\LoginController@do_register");


//商城前台项目



Route::middleware(['Api_header_kua_yu'])->group(function () {
    //分类接口
    Route::get("index/goods/category_port","Index\GoodsController@category");
    //新品接口
    Route::get("index/goods/new_goods_port","Index\GoodsController@new_goods");
    //商品列表(根据分类id)
    Route::get("index/goods/cate_goods_port","Index\GoodsController@cate_goods");
    //商品详情(根据商品id)
    Route::get("index/goods/goods_detail_port","Index\GoodsController@goods_detail");
    //前台登录接口
    Route::get("index/login","Index\LoginController@login");
    //前台查询用户信息
    Route::get("index/get_user_info_1","Index\LoginController@get_user_info_1");

    Route::middleware(['my_token_verify'])->group(function () {
        //加入购物车
        Route::any("index/goods/add_cart_port","Index\GoodsController@add_cart");
    });


});

//Route::middleware(['Api_prevent_refresh','Api_header_kua_yu','my_token_verify'])->group(function () {
//    //加入购物车
//    Route::any("index/goods/add_cart_port","Index\GoodsController@add_cart");
//});

//退出接口
Route::get("Api_prevent_refresh","Index\GoodsController@test");

//__________________________第三周测试开始______________________________
//登录接口
Route::get("thirdly_week_test/login","thirdly_week_test\LoginController@login");
//退出接口
Route::get("thirdly_week_test/login_out","thirdly_week_test\LoginController@login_out");

//登陆视图
Route::get('/thirdly_week_test/login_view',function(){
    return view('test.thirdly_week_test.login_view');
});
//天气视图
Route::get('/thirdly_week_test/tianqi_view',function(){
    return view('test.thirdly_week_test.tianqi_view');
});

Route::middleware(['check_login_api_thirdly_week_test'])->group(function () {
//查询天气
    Route::get("thirdly_week_test/chaxun_tianqi","thirdly_week_test\ApiController@chaxun_tianqi");
});

//______________________________第三周测试结束__________________________________


//每日一练
//字符串反转
Route::get("test_1","EveryDay\TestController@test_1_0916");
//中文反转
Route::get("test_2","EveryDay\TestController@Chinese_fanzhuan");

