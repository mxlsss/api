<?php
namespace App\Http\Controllers;
use App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Log;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
class AlipayController extends Controller{
    protected $config = [
        'app_id' => '2016100100643257',//你创建应用的APPID
        'notify_url' => 'http://api.1905.com/notify',//异步回调地址
        'return_url' => 'http://api.1905.com/return',//同步回调地址
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3uXzgvX87yQ6egJ+URkv6ExKCWJWweFM2ahWXUE/E9qN00WHC3ygoNfrutuv6pBehRJyRyIavCzMyqizUZIj5FRncBaGBhehvZrLegAc3bCVThOIfPnaeJ7tW8nL9g3+d3yjzMhILyn+0pZo5BU7hwiNRZ79H2g2EMtg6lXeZNLN9F4bgZJVTv2Uia169vCel95RP3N5mRutu5bz01KuXH8C8xJqrEM6fIbMdhnXPK9GckcQ9gsOuJcXHTPi9Y1uourlxZmq1WuplVjQdoZovbY09hsmXgC4vyjR0TNE1W9sqD1cXNdYJJrqZ4rMaip2ju5Qs9O/UiaZ6hNMNZ8qDQIDAQAB',//是支付宝公钥，不是应用公钥,  公钥要写成一行,不要换行
        // 加密方式： **RSA2**
        //密钥,密钥要写成一行,不要换行
        'private_key' => 'MIIEpAIBAAKCAQEA28ypUgt3DEaLj3kFZpvfEut4tYQ9ILkbBalczIutg0dZ8yqS22hOQfXKJzmmpJbDl5Hk7Cn4BY8K9wY1imeiiumEx/8SlvpPDL4NkC+LoiGkb4i67S5mQkAYeXBnxxUQHqQCiXgZsTx+06gOxQAoKREAusTojsw1p92EDYM8Bq/calNEg3h1RinQzf5Vu6OoRou/yDjmvs9a7rfkTKpdBuCrh/WOU7G61TSTNRx1KqFRCVlMu+XnZdLrkI4RPsFwtzS+k+ZN4KCrsdGCAwujLkzbUvpEjdMQncDHWwVo+eU3qa/muE5ECoI2QvZtXSRh+OAkXv4XzpmkhzmbzYBjhwIDAQABAoIBAGlgiZzoGj8sYyR55Pj4qc4sTkbYC2Zw2F+yfuch4CIcRyeptZazPzGoYS7FGPu3vDYioBoJVPt1RNCBjZG5ddgbdKldxM/VWajGRUJnSQ6GCovehZ/IqwYALLusBFUR6BSIlR7LEaZDVpqq68nO9XIa0Lq6RLSRevfr36+Kx3B8ZDvxeRw8LIYXhdTK8ai8ayY4yxivSvvyXxMTH1HpnAtLSqu4VnkO4ZzDk3pNLGpljiVN4XoJ4zNvRZjT3wg0M6OkHLh3VAWePD7YbSeta5NuSStS9tCzFdnswMI7JM36093YcttPV+L9MoQEhVdc5UsJPmZKdWTKF0UYsv9qW0ECgYEA8C9GWiC5OMXH6Sdv9/xwN4A0hpu072+SOTqMrq5Wk9RQChlEXxpMN3Y65hwLaq/eOxA1leCCfIZgQ2gshCM67POaoJ5DkmSUhFfbd0RyQRTZzxKVf4ems9J75EOTWqH+H81D256R3wRyx8VNKRGt5Lg/V9CsZWyDjtyIKwnEVK8CgYEA6kXCRjZhbyEFix9+cSQVt/8dO9WTnL8DjUYf6d6F/gUKiVLFHLOJFJkbgNtmTwVzuRlWwuI0egyhi+aZ3nxkKlYhwbDFZ6dPPif2I8X57EbuTQ+zuC+lUYJoW0MFJU+Hpw8hcADZ7ahSET0sCs5DgxY0+i/MkPvaecrDO/d6RKkCgYEA2Zc6ePQkWNZ04TilK1g6oU04SKpPJItDQS1Vvfqa3Jn/WObDFhVQ7v3hJg5KGYDyJzfsE7es/vsNwoNhsOPpwjh+4Pv/42PTWIHvhQExMNye5gXEAiD2WPpa2tSNbhJLkqv2ycPCCvSQt4J7ALXPf+GbIQce51ODa61Gfxb+EmkCgYEArRwtCUrnxoFFIl98REhg0BxwUqVoNRwkmMDnlh37LxA0j/Kceq/jrFfSre3xdJTXxUAHD2ytUD6DJOiabH/IWExbF0/zHrvP32MSC68gFUr4jfL7Xy+93jQZvs4QQFi7KWQR1jyazHVjZx+nqrhtxLClJvYpGD0yXGrKx0YAkDkCgYBPit24xdaGyW9a1H0TurEW7gP1Inpn7+cQvpIWFsIQHxTloqJmAPRFGb9Hx0H3Zs2F2XbkS+CAFPVsK1ZL/OjI30uBkFh5rtlxSrcgRmkWf7U//3DFCe2IqrRA6XGH5ZZlSEZXaR/Gr5ar4c1sL4uQMQmkS7hwecYzUIfrLrnToQ==',
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];

    public  function zhifu(){

        return view('zhifu.zhifu');
    }
    public function Alipay()
    {
          $total_amount=$_GET['amount'];
        $order = [
            'out_trade_no' => time(),
            'total_amount' => $total_amount,
            'subject' => 'test subject - 测试',
        ];

        $alipay = Pay::alipay($this->config)->web($order);

        return $alipay;
    }

    public function AliPayReturn()
    {
        $data = Pay::alipay($this->config)->verify(); // 是的，验签就这么简单！

        echo"支付完成"; echo"</br>";
      echo"  订单号：$data->out_trade_no</br>
         支付宝交易号：$data->trade_no </br>
         订单总金额：$data->total_amount";
    }

    public function AliPayNotify()
    {
        $alipay = Pay::alipay($this->config);

        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (\Exception $e) {
            //$e->getMessage();
        }

        return $alipay->success();
    }
}