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
}
