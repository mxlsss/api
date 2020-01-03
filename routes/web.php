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



//支付
Route::get('zhifu','Alipay\TestController@zhifu');  // 填写金额
Route::get('/test/pay','Alipay\TestController@alipay');        //去支付
Route::get('/test/alipay/return','Alipay\PayController@aliReturn');
Route::post('/test/alipay/notify','Alipay\PayController@notify');

//注册
Route::post('login/reg','Api\LoginController@reg');
//登陆
Route::post('login/','Api\LoginController@login');
//列表
Route::get('login/list','Api\LoginController@userList')->middleware('login');
