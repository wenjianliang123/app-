<?php

namespace App\Http\Middleware;

use Closure;

class Api_header_kua_yu
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
        //    *等价于所有
        // 制定允许其他域名访问
//        echo 1;die;
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:*');
        //请求头
        header('Access-Control-Allow-Headers:*');
        // 响应头设置
        header('Access-Control-Allow-Credentials:false');
        //数据类型
        header('content-type:application:json;charset=utf8');
//        header("content-type:text/html;charset=utf-8");  //设置编码


        // 制定允许其他域名访问
      /* header("Access-Control-Allow-Origin:*");
// 响应类型
        header('Access-Control-Allow-Methods:POST');
// 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with, content-type');*/
        return $next($request);
    }
}
