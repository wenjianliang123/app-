<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tool\common;

class get_post_controller extends Controller
{
    public $common;
    public function __construct(common $common)
    {
        $this->common=$common;
    }
    //测试get post 封装在一个方法中
    public function test()
    {
        //get
        /*
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET');
        $aa=$this->common->get_post($url);
        dd($aa);
        */

        //post
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->common->get_access_token();
        $data=[
            "type"=>"image",
            "offset"=>0,
            "count"=>1
        ];
        $post_data=$this->common->get_post($url,json_encode($data));
//        dd($post_data);
    }
}
