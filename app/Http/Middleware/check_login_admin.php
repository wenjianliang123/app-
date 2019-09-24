<?php

namespace App\Http\Middleware;

use Closure;

class check_login_admin
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
        $loginInfo=session('admin_user_id');
        if(!empty($loginInfo)){
            return $next($request);
        }else{
//            echo "未登录";
            return redirect('admin/login');
        }
    }
}
