<?php

namespace App\Http\Controllers\fs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class FangShua extends Controller
{
    public function  fs(){
//        echo '<pre>';print_r('123');echo'</pre>';
        $user_token=$_SERVER['HTTP_TOKEN'];//获取token
//        echo '<pre>';print_r($user_token);echo'</pre>';
        $current_url=$_SERVER['REQUEST_URI'];//获取当前url
//        echo '<pre>';print_r($current_url);echo'</pre>';
        $redis_key = 'str:count:u:'.$user_token.':url:'.md5($current_url);
        echo 'rediskey:'.$redis_key; echo '</br>';
        $count = Redis::get($redis_key);        //获取接口的访问次数
        echo "接口的访问次数： ".$count; echo '</br>';
        if($count >= 5){
            echo "请不要频繁访问此接口，访问次数已到上限，请稍后再试";
            Redis::expire($redis_key,20);
            die;
        }
        $count = Redis::incr($redis_key);
//        echo 'count: '.$count;
    }
}
