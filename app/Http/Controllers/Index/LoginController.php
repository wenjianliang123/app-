<?php

namespace App\Http\Controllers\Index;

use App\Model\Index_login;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Tool\common;

class LoginController extends Controller
{
    public function login(Request $request)
    {


        $user_name=$request->user_name;
        $user_pwd=$request->user_pwd;
        if(!empty($user_name)&&!empty($user_pwd)){
            $user_info=Index_login::where(['index_user_name'=>$user_name,'index_user_pwd'=>$user_pwd])->first();
//            dd($is_true);
            if($user_info){
                //查到数据，登陆成功
//                echo 1;die();
//                dd($user_info['index_user_id']);
                $token=md5($user_info->user_id.time());
                $token_expire=time()+7200;
                $user_info->token=$token;
                $user_info->token_expire=$token_expire;
                $user_info->save();
                //返回给客户端
                return json_encode(['code'=>200,'msg'=>'登陆成功','token'=>$token]);
            }else{
                //登陆失败，用户密码不对
//                echo 2;die();
                return json_encode(['code'=>500,'msg'=>'登陆失败，用户密码不对']);
            }
        }


    }
    //获取前台用户信息
    public function get_user_info_1(Request $request)
    {
        $token=$request->token;
        $user_info=common::get_user_info_2($token);
        return $user_info;
    }
}
