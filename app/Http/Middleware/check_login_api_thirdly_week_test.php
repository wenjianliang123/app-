<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Thirdly_Week_Test_Login;

class check_login_api_thirdly_week_test
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
        $token=$request->token;
        if(!empty($token)){
            $user_info=Thirdly_Week_Test_Login::where('token',$token)->first();
            if($user_info){
                return $next($request);
            }else{
//                echo "<script>alert('token错误');location.href('http://www.dijiuyue.com/thirdly_week_test/login')</script>";die;
                return redirect('thirdly_week_test/login_view');
            }
        }else{
//            return 'token不能为空';
//            echo "token不能为空";die;
            echo "<script>alert('token不能为空');history.back()</script>";die;
        }

    }
}
