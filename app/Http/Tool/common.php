<?php

namespace App\Http\Tool;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class common extends Controller
{
    //用curl 写的
    public static function curl_get_post_originData($url,$method="GET",$postData=[],$header=[])
    {
        //1初始化
        $ch = curl_init();
        //2设置
        curl_setopt($ch,CURLOPT_URL,$url); //访问地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //返回格式
        if($method="POST"){
            curl_setopt($ch,CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($ch,CURLOPT_POSTFIELDS,$postData); // Post提交的数据包
        }
        if (!empty($header)){
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); // 对认证证书来源的检查
        //3执行
        $content = curl_exec($ch);

        //4关闭
        curl_close($ch);
        return $content;
    }

    //用curl 封装HTTP中的get和post 请求方式 自己写的不成熟
    public function get_post($url,$data='')
    {
        //1初始化
        $ch = curl_init();
        //2设置
        curl_setopt($ch,CURLOPT_URL,$url); //访问地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //返回格式
        if(empty($data)){
            //get
            //请求网址是https
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); // 对认证证书来源的检查
            //3执行
            $content = curl_exec($ch);
        }else{
            //post
            curl_setopt($ch,CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data); // Post提交的数据包
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); // 对认证证书来源的检查
            //3执行
            $content = curl_exec($ch);
        }
        //4关闭
        curl_close($ch);
        return $content;
    }
    //获取access_token
    public static function get_access_token()
    {
        $access_token_key='wechat_access_token';
        $redis=new \Redis();
        $redis->connect('127.0.0.1','6379');
        //在方法中判断key
        if($redis->exists($access_token_key))
        {
            //从缓存中拿access_token
            $access_token=$redis->get($access_token_key);
//            echo '这是从缓存中拿到的access_token';
//            dd($access_token);
        }else{
            //如果没有 调用接口拿access_token 并存入redis
            $access_token_info=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
            $access_token_info=json_decode($access_token_info,1);
//            dd($access_token_info);
            //数组的操作需要json_decode($data,1)变为关联数组
            $access_token=$access_token_info['access_token'];
            $expires_in=$access_token_info['expires_in'];
            $redis->set($access_token_key,$access_token,$expires_in);
        }
        //最终返回一个access_token
        return $access_token;
    }

    //清零调用接口次数限制
    public static function empty_api_count()
    {
        $url="https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=".self::get_access_token();
        $data=[
            "appid"=>env('WECHAT_APPID')
        ];
        $re=self::curl_get_post_originData($url,"POST",json_encode($data));
        dd($re);

    }
}
