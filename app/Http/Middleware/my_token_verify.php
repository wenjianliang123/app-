<?php

namespace App\Http\Middleware;

use App\Http\Tool\Rsa;
use App\Models\v2\Region;
use Closure;
use App\Model\Index_login;

class my_token_verify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->verify_token($request);
//        $token=$_SERVER['HTTP_TOKEN'];
        return $next($request);

    }

    public function verify_token($request)
    {
        $token=$request->token;
        //判断token是否不为空
        if(!empty($token)){
            $token_info=Index_login::where('token',$token)->first();
            //判断token是否正确
            if($token_info){
                //判断超出时间没有
                if(!(time()>$token_info['token_expire'])){
                    $token_info->token_expire=time()+7200;
                    $token_info->save();
                    //把token_info转为数组
                    $token_info=json_decode(json_encode($token_info),1);
                    //合并参数必须是数组
                    $request->merge($token_info);//合并参数
                    echo json_encode(['code'=>200,'msg'=>'查询成功','data'=>$token_info],JSON_UNESCAPED_UNICODE);
//                    echo 1;die;

                }else{
//                    return redirect('index/login');
                    echo  json_encode(['code'=>401,'msg'=>'token已过期，请重新登录'],JSON_UNESCAPED_UNICODE);die;
                }

            }else{
                //没有这个数据
                echo json_encode(['code'=>402,'msg'=>'查询失败，token不对'],JSON_UNESCAPED_UNICODE);die;
            }
        }else{
            echo json_encode(['code'=>403,'msg'=>'token不能为空'],JSON_UNESCAPED_UNICODE);die;
        }
    }

}
