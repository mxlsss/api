<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;
use Closure;

class Listlogin
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
        $user_token = $_SERVER['HTTP_TOKEN'];
        echo 'user_token: '.$user_token;echo '</br>';
        $current_url = $_SERVER['REQUEST_URI'];
        echo "当前URL: ".$current_url;echo '<hr>';
        //echo '<pre>';print_r($_SERVER);echo '</pre>';
        //$url = $_SERVER[''] . $_SERVER[''];
        $redis_key = 'str:count:u:'.$user_token.':url:'.md5($current_url);
        echo 'redis key: '.$redis_key;echo '</br>';
        $count = Redis::get($redis_key);       //获取接口的访问次数
        $aaa=$count+1;
        echo '<pre>';print_r("接口的访问次数： ".$aaa);echo'</pre>';
        if($count >= 5){
            echo '<pre>';print_r("请不要频繁访问此接口，访问次数已到上限，请5秒后再试");echo'</pre>';
            Redis::expire($redis_key,5);
            die;
        }
        $count = Redis::incr($redis_key);
        return $next($request);
    }
}
