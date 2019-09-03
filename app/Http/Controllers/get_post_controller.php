<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tool\common;
use App\Model\wechat_openid;

class get_post_controller extends Controller
{
    /*public $curl;
    public function __construct(common $common)
    {
        $this->curl=$common;
    }*/
    //测试get post  封装在一个方法中  自己写的不成熟代码
    public function test()
    {
        //get
        /*
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET');
        $aa=$this->common->get_post($url);
        dd($aa);
        */

        //post
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->curl->get_access_token();
        $data=[
            "type"=>"image",
            "offset"=>0,
            "count"=>1
        ];
        $post_data=$this->curl->get_post($url,json_encode($data));
        dd($post_data);
    }

    //测试二 老师提供的代码 get post 原始数据xml、json
    public function test_1()
    {
        //get
        /*$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET');
        $aa=common::curl_get_post_originData($url);
        dd($aa);*/


        //post
        /*$url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".common::get_access_token();
        $data=[
            "type"=>"image",
            "offset"=>0,
            "count"=>1
        ];
        $post_data=common::curl_get_post_originData($url,"POST",json_encode($data));
        dd($post_data);*/

        //原始xml、json数据  有点问题
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".common::get_access_token();
        $data=[
            "type"=>"image",
            "offset"=>0,
            "count"=>1
        ];
//        echo 1;die;
        $header[]="Content-type: text/xml;charset='utf-8'";
        $post_data=common::curl_get_post_originData($url,"POST",json_encode($data),$header);
//        echo 1;die;
        dd($post_data);
    }

    //做一个可供别人访问的接口 （用模型做）
    public function wechat_openid()
    {
        $data=wechat_openid::get()->toarray();
        dd($data);
    }

    //file_get_contents get方式 post方式
    public function file_get_contents_get_post()
    {

        // file_get_contents发送http请求

        //file_get_contents发送get请求
        /*$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET');
        $data = file_get_contents($url);
        var_dump($data);die;*/


        //file_get_contents发送post请求
//        $url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".common::get_access_token();
//        $info=[
//            "filter"=>[
//                "is_to_all"=>false,
//                "tag_id"=>111
//               ],
//               "text"=>[
//                   "content"=>"fgn"
//               ],
//                "msgtype"=>"text"
//            ];
//         $context = stream_context_create(array(
//         	'http' => array(
//         			'method' => 'POST',
//         			'header' => 'Content-type:application/x-www-form-urlencoded',
//         			'content' => json_encode($info),   /*http_build_query*/// ?name=zhangsan&age=11
//         			'timeout' => 20
//             )
//         ));
//         $result = file_get_contents($url, false, $context);
//         var_dump($result);die;





        //curl方式
        /**
         * php使用curl方式  发送get请求
         *
         */
//        1初始化
         /*$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET');
         $ch = curl_init();
         //2设置
         curl_setopt($ch,CURLOPT_URL,$url); //访问地址
         curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //返回格式
         //请求网址是https
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); // 对认证证书来源的检查
         //3执行
         $content = curl_exec($ch);
         //4关闭
         curl_close($ch);
         return $content;*/

        /**
         * php  curl发送post请求
         *
         */
        /*$url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".common::get_access_token();
        $info=[
            "filter"=>[
                "is_to_all"=>false,
                "tag_id"=>105
               ],
               "text"=>[
                   "content"=>"fgn"
               ],
                "msgtype"=>"text"
            ];
        $postData = json_encode($info);//http_build_query这个可以转化为 name=11&password=22
        //1初始化
                $ch = curl_init();
        //2设置
                curl_setopt($ch,CURLOPT_URL,$url); //访问地址
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //返回格式
                curl_setopt($ch,CURLOPT_POST, 1); // 发送一个常规的Post请求
                curl_setopt($ch,CURLOPT_POSTFIELDS,$postData); // Post提交的数据包
        //如果发送json数据
        // $header[] = "Content-type: application/json;charset='utf-8'"; //json
        // curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        //请求网址是https
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); // 对认证证书来源的检查
        //3执行
                $content = curl_exec($ch);
        //4关闭
                curl_close($ch);



                var_dump($content);die;*/
    }
}
