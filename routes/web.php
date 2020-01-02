<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/info',function(){
    phpinfo();
});
Route::get('zhifu','AlipayController@zhifu');  // 填写金额
Route::get('alipay','AlipayController@Alipay');  // 发起支付请求
Route::any('notify','AlipayController@AliPayNotify'); //服务器异步通知页面路径
Route::any('return','AlipayController@AliPayReturn');  //页面跳转同步通知页面路径




Route::get('/test/pay','Alipay\TestController@alipay');        //去支付
Route::get('/test/alipay/return','Alipay\PayController@aliReturn');
Route::post('/test/alipay/notify','Alipay\PayController@notify');

