<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;

class LoginController extends Controller
{

    //注册
    public function reg(Request $request){
//        echo "$request->input()";
        $password2 = $request->input('password2');

        if($request->input('password')!=$password2){
            echo "两次密码不一致";die;
        };

        $data=[
            'name'=> $request->input('name') ,
            'email'=> $request->input('email') ,
            'password'=>  password_hash($request->input('password'),PASSWORD_BCRYPT),
            'last_login'    => time(),
            'last_ip'       => $_SERVER['REMOTE_ADDR'],     //获取远程IP
        ];
  echo '<pre>';print_r($data);echo'</pre>';

        $aaa=UserModel::insertGetId($data);
        if($aaa){
            echo "注册成功";
        }
    }

    //登陆
    public function login(Request $request){

        $name = $request->input('name');
        $password = $request->input('password');
        $u = UserModel::where(['name'=>$name])->first();
        if($u){
            //验证密码
            if( password_verify($password,$u->password) ){
                // 登录成功
                //echo '登录成功';
                //生成token
                $token = Str::random(32);
                $response = [
                    'errno' => 0,
                    'state'=> '登陆成功',
                    'msg'   => 'ok',
                    'data'  => [
                        'appid'=>$u['appid'],
                        'token' => $token
                    ]
                ];
            }else{
                $response = [
                    'errno' => 400003,
                    'msg'   => '密码不正确'
                ];
            }
        }else{
            $response = [
                'errno' => 400004,
                'msg'   => '用户不存在'
            ];
        }
            return $response;
     }

    //列表
    public function userList()
    {
        $data = [
            'name' => '马祥龙',
            'email'     => '1113943731@qq.com',
        ];
        echo '<pre>';print_r($data);echo'</pre>';

    }


    //get
    public function qm(){

        $data="hello";
        $key="mxl";

        //生成签名
        $signature=md5($data.$key);

        echo "待发送的数据：". $data;echo '</br>';
        echo "签名：". $signature;echo '</br>';

        //发送数据
        $url = "http://1905passport.hcws.vip/yq?data=".$data .'&signature='.$signature;
//        $url = "http://1905passport.com/yq?data=".$data .'&signature='.$signature;
        echo $url;echo '<hr>';

        $response = file_get_contents($url);
        echo $response;

        
    }

    //post 签名
    public function qm2(){

            $key = "1905mxl";          // 签名使用的key

            //待签名的数据
            $order_info = [
                "order_id"          => 'mxl' . mt_rand(111111,999999),
                "amount"      => mt_rand(1111,9999),
                "uid"               => 888,
                "add_time"          => time(),
            ];

            //数据转换
            $data_json = json_encode($order_info);

            //计算签名
            $sign = md5($data_json.$key);

            // post 表单（）发送数据
            $client = new Client();
            $url = 'http://1905passport.hcws.vip/yq2';
            $response = $client->request("POST",$url,[
                "form_params"   => [
                    "data"  => $data_json,
                    "sign"  => $sign
                ]
            ]);

            //接收服务器端响应的数据
            $response_data = $response->getBody();
            echo $response_data;

        }

    //公钥私钥 加密
    public function jiami(){
        $data="1905_马祥龙";
        echo '<pre>';print_r("原文:".$data);echo'</pre>';
        $key=file_get_contents(storage_path('keys/priv.key'));
//        echo '<pre>';print_r($key);echo'</pre>';
        openssl_private_encrypt($data,$ent_data,$key);
        echo '<pre>加密后:';print_r($ent_data);echo'</pre>';
        $ent_data=base64_encode($ent_data);
        echo '<pre>';print_r($ent_data );echo'</pre>';
        $url_ent_data=urlencode($ent_data);
        echo '<pre>ba64和url编码后';print_r($url_ent_data);echo'</pre>';

        echo"</br>";echo "<h1></h1>";
        $url = 'http://1905passport.hcws.vip/jiemi?data='.$url_ent_data;
        $server=file_get_contents($url);
        echo '<pre>';print_r($server);echo'</pre>';

    }



}
