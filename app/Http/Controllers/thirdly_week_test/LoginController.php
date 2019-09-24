<?php

namespace App\Http\Controllers\thirdly_week_test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Thirdly_Week_Test_Login;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user_name=$request->user_name;
        $user_pwd=$request->user_pwd;
//        return $user_name;
//        return $user_pwd;
//
        if(!empty($user_name)&&!empty($user_pwd)){
            $user_info=Thirdly_Week_Test_Login::where(['user_name'=>$user_name,'user_pwd'=>$user_pwd])->first();
            if($user_info){
                $token=md5($user_info->user_id.time());
                $token_expire=time()+7200;
                $user_info->token=$token;
                $user_info->token_expire=$token_expire;
                $user_info->save();
                return json_encode([
                    'code'=>200,
                    'msg'=>'登陆成功,您的token是'.$token.'',
                    'token'=>$token,
                    'token_expire'=>$token_expire,
                ],JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(['code'=>500,'msg'=>'token不存在'],JSON_UNESCAPED_UNICODE);
            }

        }else{
            return json_encode(['code'=>500,'msg'=>'用户名密码不能为空'],JSON_UNESCAPED_UNICODE);
        }
    }

    public function login_out(Request $request)
    {
        $token=$request->token;
        $user_info=Thirdly_Week_Test_Login::where('token',$token)->first();
        if($user_info){
            $user_info->token_expire=1111;
            $user_info->save();
            if(time()>$user_info->token_expire){
                return json_encode(['code'=>200,'msg'=>'退出成功'],JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(['code'=>500,'msg'=>'当前时间没有比有效期大'],JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(['code'=>500,'msg'=>'token错误，查无此人'],JSON_UNESCAPED_UNICODE);
        }
    }
}
