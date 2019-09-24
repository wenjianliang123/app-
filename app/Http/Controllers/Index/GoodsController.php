<?php

namespace App\Http\Controllers\Index;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods_category_model;
use App\Model\Goods_model;
use App\Model\Goods_attribute_model;

class GoodsController extends Controller
{
    //分类数据+缓存+jsonp
    public function category()
    {
        //加入缓存
//        Cache::forget('cate_goods');
        $cache_key='cate_goods';
        $cate_goods_info=Cache::get($cache_key);

        if(empty($cate_goods_info)){
//            echo 1;die();
            $cate_goods_info=Goods_category_model::where('parent_id',0)->limit(8)->get();
//            存入缓存
            Cache::put($cache_key,json_encode($cate_goods_info,JSON_UNESCAPED_UNICODE),86400);
        }

        //判断是否是jsonp请求
        if(isset($_GET['jsoncallback'])){
            //是jsonp请求
//            echo 1;die();
            $callback = $_GET['jsoncallback'];
            return $callback."(".$cate_goods_info.")";
        }else{
            //普通请求
            //拿到顶级分类
//            echo 2;die();
            return $cate_goods_info;

        }


    }
    //新品数据+缓存+jsonp
    public function new_goods()
    {
        //加入缓存 默认驱动file 可在env中的cache_driver配置 redis memcache Windows不能使用memcached
//        Cache::forget('new_goods');
        $cache_key='new_goods';
        //从缓存中拿数据
        $new_goods_data=Cache::get('new_goods');
//        $new_goods_data=json_decode($new_goods_data);
        if(empty($new_goods_data)){
//            echo 1;die;
            //从数据库中拿数据
            //拿到最新的四件商品
            $new_goods_data=Goods_model::orderBy('goods_id','desc')->limit(4)->get();
            foreach($new_goods_data as $k =>$v){
            $new_goods_data[$k]['goods_img']='http://www.dijiuyue.com'.'/'.$v['goods_img'];
        }
//            存入缓存
            Cache::put($cache_key,json_encode($new_goods_data,JSON_UNESCAPED_UNICODE),86400);
        }

        //判断是否是jsonp请求
        if(isset($_GET['jsoncallback'])){
            //是jsonp请求
//            echo 1;die();
            $callback = $_GET['jsoncallback'];
            return $callback."(".$new_goods_data.")";
        }else{
            //普通请求
            //拿到顶级分类
//            echo 2;die();
            return $new_goods_data;

        }

    }
    //商品列表
    public function cate_goods(Request $request)
    {
        //'+'http://www.dijiuyue.com/'+'/
        $cate_id=$request->input('cate_id');
        $cache_key='cate_goods'.$cate_id;
//        Cache::forget($cache_key);

        $cate_goods_info=Cache::get($cache_key);
//        return json_encode($cate_goods_info);
        if(empty($cate_goods_info)){
//            echo 1;die;
            $cate_goods_info=Goods_model::where('cate_id',$cate_id)->limit(6)->get();

            foreach($cate_goods_info as $k =>$v){
                $cate_goods_info[$k]['goods_img']='http://www.dijiuyue.com'.'/'.$v['goods_img'];
            }
        Cache::put($cache_key,json_encode($cate_goods_info),86400);
        }

        //判断是否是jsonp请求
        if(isset($_GET['jsoncallback'])){
            //是jsonp请求
//            echo 1;die();
            $callback = $_GET['jsoncallback'];
            return $callback."(".$cate_goods_info.")";
        }else{
            //普通请求
            //拿到顶级分类
//            echo 2;die();
            return $cate_goods_info;

        }
    }

    //商品详情
    public function goods_detail(Request $request)
    {
        /*$good_id=$request->goods_id;
        $cache_key='goods_detail'.$good_id;
        $data=Cache::get($cache_key);
        if(empty($data)){
            //获取商品数据
            $goods_info=Goods_model::where('goods.goods_id',$good_id)->first();
            //【两表联查】获取属性表和商品属性关系表数据
            $attr_info=Goods_attribute_model::join('goods_attr_relation','goods_attribute.attribute_id','=','goods_attr_relation.attr_id')->where('goods_attr_relation.goods_id',$good_id)->get()->toarray();

            //将规格和参数分组
            $attr_special_info=[];
            //参数数组
            $attr_general_info=[];
            foreach ($attr_info as $k=> $v)
            {

                if($v['attribute_is']==2){
                    //代表此时是规格
                    $attr_special_info[$v['attr_id']][]=$v;
                }else{
                    $attr_general_info[]=$v;
                }
//                $new_attr_info[$v['attr_id']][]=$v;
            }

            return ;
            //将商品数据和商品属性以及商品属性关系表的数据放入一个数组
            $data=[
                //普通商品数据
                'goods_info'=>$goods_info,
                //规格数据
                'attr_special_info'=>$attr_special_info,
                //参数数据
                'attr_general_info'=>$attr_general_info,
            ];

            Cache::put($cache_key,json_encode($data),JSON_UNESCAPED_UNICODE,86400);
        }

//        return $data;



        //判断是否是jsonp请求
        if(isset($_GET['jsoncallback'])){
            //是jsonp请求
//            echo 1;die();
            $callback = $_GET['jsoncallback'];
            return $callback."(".$data.")";
        }else{
            //普通请求
            //拿到顶级分类
//            echo 2;die();
            return $data;

        }*/

        $good_id=$request->goods_id;
        $cache_key='goods_detail'.$good_id;
//        Cache::forget($cache_key);
        $data=Cache::get($cache_key);
        if(empty($data)){
            $goods_info=Goods_model::where('goods.goods_id',$good_id)->first();

            //【两表联查】获取属性表和商品属性关系表数据
            $attr_info=Goods_attribute_model::join('goods_attr_relation','goods_attribute.attribute_id','=','goods_attr_relation.attr_id')->where('goods_attr_relation.goods_id',$good_id)->get()->toarray();
//        return $attr_info;

            //将规格和参数分组
            $attr_special_info=[];
            //参数数组
            $attr_general_info=[];
            foreach ($attr_info as $k=> $v)
            {

                if($v['attribute_is']==2){
                    //代表此时是规格
                    $attr_special_info[$v['attr_id']][]=$v;
                }else{
                    $attr_general_info[]=$v;
                }
//                $new_attr_info[$v['attr_id']][]=$v;
            }

            //将商品数据和商品属性以及商品属性关系表的数据放入一个数组
            $data=[
                //普通商品数据
                'goods_info'=>$goods_info,
                //规格数据
                'attr_special_info'=>$attr_special_info,
                //参数数据
                'attr_general_info'=>$attr_general_info,
            ];
            Cache::put($cache_key,json_encode($data),86400);
        }


//        return $data;

        //判断是否是jsonp请求
        if(isset($_GET['jsoncallback'])){
            //是jsonp请求
//            echo 1;die();
            $callback = $_GET['jsoncallback'];
            return $callback."(".$data.")";
        }else{
            //普通请求
            //拿到顶级分类
//            echo 2;die();
            return $data;

        }
    }

    //加入购物车
    public function add_cart(Request $request)
    {
//       return 1;
        $all_params =  $request->input();//获取参数
//        echo 1;die;
//        return json_encode(1);
//        return $all_params;
        $user_id=$all_params['index_user_id'];
        echo json_encode($user_id);
    }

    public function test(Request $request)
    {
        $ip = $_SERVER["REMOTE_ADDR"];
//        $ip=$_SERVER['HTTP_USER_AGENT'];
//        $ip=$_SERVER;

        dd($ip);
        $redis_key='pass_time_ip'.$ip;
        if($ip){
            echo json_encode($ip);
            //从缓存读取次数 key ： pass_time_ip 1 缓存时间 60s
            $redis= new \Redis();
            $redis->connect('127.0.0.1','6379');
            //同一个ip一分钟只能调用60次
            //限制次数为10
            $limit = 20;
//            $redis->flushAll();die;
            $check = $redis->exists($redis_key);
            if($check){
                $redis->incr($redis_key);  //键值递增
                $count = $redis->get($redis_key);
                //如果大于60次报错
                if($count > $limit){
                    exit('你手速有点快啊 兄弟');
                }
            }else{
                $redis->incr($redis_key);
                //限制时间为60秒
                $redis->expire($redis_key,60);
            }
            //不大于60次 次数累加、正常访问
            $count = $redis->get($redis_key);
            echo 'You have '.$count.' request';die;

        }else{
            echo  '没有ip';die;
        }
    }



}
