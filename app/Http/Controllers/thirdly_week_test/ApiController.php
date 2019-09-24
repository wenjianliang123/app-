<?php

namespace App\Http\Controllers\thirdly_week_test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Tool\common;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    public function chaxun_tianqi(Request $request)
    {
        $city_name=$request->city_name;
        $cache_key='tianqi'.$city_name;
        $tianqi_info=Cache::get($cache_key);
        if(empty($tianqi_info)){
//        dd($city_name);
            //通过城市名称查询城市id
//        http://api.k780.com:88/?app=weather.future&weaid=1&appkey=你申请的AppKey&sign=你申请的Sign&format=json
            $tianqi_info=common::curl_get_post_originData('http://api.k780.com:88/?app=weather.future&weaid='.$city_name.'&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json','get');

            //假数据怕浪费次数限制 加入缓存就不用这样做了

            /*$tianqi_info='"success":  "1",
    "result":
        "weaid":  "1","days":  "2014-07-30","week":  "星期三","cityno":  "beijing","citynm":  "北京","cityid":  "101010100","temperature":  "31℃/24℃","humidity":  "87.8℉/75.2℉","weather":  "多云转晴","weather_icon":  "http://api.k780.com:88/upload/weather/d/1.gif","weather_icon1":  "http://api.k780.com:88/upload/weather/d/0.gif","wind":  "微风","winp":  "小于3级","temp_high":  "31","temp_low":  "24","humi_high":  "87.8","humi_low":  "75.2","weatid":  "2","weatid1":  "1","windid":  "1","winpid":  "2"';*/
            $tianqi_info=json_encode($tianqi_info);
            //得到明天凌晨时间戳
            $tomorrow_morning=strtotime(date('Y-m-d',strtotime('+1 day')));
            //缓存时间 明天减去现在
            $expire_time=$tomorrow_morning-time();
//        dd($expire_time);

            Cache::put($cache_key,$tianqi_info,$expire_time);
        }


        if($tianqi_info){
            return $tianqi_info;
        }else{
            return '查询失败';
        }

    }
}
