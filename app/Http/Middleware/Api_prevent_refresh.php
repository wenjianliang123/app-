<?php

namespace App\Http\Middleware;

use Closure;

class Api_prevent_refresh
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
        $ip = $_SERVER["REMOTE_ADDR"];
        $redis_key='pass_time_ip'.$ip;
        if($ip){
            echo json_encode($ip);
            //从缓存读取次数 key ： pass_time_ip 1 缓存时间 60s
            $redis= new \Redis();
            $redis->connect('127.0.0.1','6379');
            //同一个ip一分钟只能调用60次
            //限制次数为10
            $limit = 20;
//            $redis->flushAll();die;
            $check = $redis->exists($redis_key);
            if($check){
                $redis->incr($redis_key);  //键值递增
                $count = $redis->get($redis_key);
                //如果大于60次报错
                if($count > $limit){
                    exit('你手速有点快啊 兄弟');
                }
            }else{
                $redis->incr($redis_key);
                //限制时间为60秒
                $redis->expire($redis_key,60);
            }
            //不大于60次 次数累加、正常访问
            $count = $redis->get($redis_key);
//            echo 'You have '.$count.' request';
            return $next($request);
        }else{
            echo  '没有ip';die;
        }


    }
}
