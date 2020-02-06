<?php

namespace App\Http\Middleware;
use GuzzleHttp\Client;
use Closure;

class checkToken
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
        //鉴权 ，验证 token是否有效
        $appid = $_SERVER['HTTP_APPID'];
        $token = $_SERVER['HTTP_TOKEN'];
        //请求passport 实现鉴权
        $client = new Client();
        $response = $client->request('POST', 'http://1905passport.com/auth', [
            'form_params' => [
                'appid' => $appid,
                'token' => $token,
            ]
        ]);

        //接收请求响应
        $response_data = $response->getBody();
        $arr = json_decode($response_data,true);

        //判断鉴权是否成功
        if($arr['errno']>0){        //鉴权失败
            echo "鉴权失败";die;
        }

        return $next($request);
        return $next($request);
    }
}
