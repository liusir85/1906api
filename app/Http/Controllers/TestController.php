<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;

class TestController extends Controller
{
    //
    public function testRedis(){
        $key="123redis";
//        $val="testredis123";
        $val=time();
        Redis::set($key,$val);
        $test=Redis::get($key);
        echo $test;
    }


    //获取微信access_token
    public function getAccessToken(){
        $app_id='wx0079197aeab14faf';
        $appsecret='e76097268baf9e05fed3c7d35c1430ab';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret.'';
        echo $url;
        echo "<br>";echo '<hr>';
        //使用file_get_contents 发送GET请求
        $response=file_get_contents($url);
        var_dump($response);echo '<hr>';
        $arr=json_decode($response,true);  //转化为数组
        echo "<pre>";print_r($arr);echo "</pre>";
    }

    public function curl1(){
        $app_id='wx0079197aeab14faf';
        $appsecret='e76097268baf9e05fed3c7d35c1430ab';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret.'';
//        echo $url;

        //初始化
        $ch=curl_init($url);

        //设置参数选项
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);//0启用浏览器输出 1 关闭浏览器输出，可用变量接收响应

        //执行会话
//        curl_exec($ch);
        $response=curl_exec($ch);

        //捕获错误
        $errno=curl_errno($ch);
        $error=curl_error($ch);
        if($errno>0) //有问题
        {
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息：".$error;die;
        }

//        var_dump($error);die;

        //关闭会话
        curl_close($ch);

//        echo "服务器响应的数据：";echo "<br>";
//        echo $response;echo '<hr>';

//        $arr=json_decode($response,true);
//        echo "<pre>";print_r($arr);echo "</pre>";

        //处理逻辑
        var_dump($response);

    }


    //curl post 请求
    public function curl2(){
        $access_token='30_CEgHGxMeDeEbJBEH-L94CaZmmNGT-iAEgsPUmAEmCfskZIkhQQU7CdXCtncrU3TDSbIXkE8bZyM0Tv0R1NUvT5VlG9cwBNc5f3pjwZ4NlIbdPQRn-jygzr9NmygVBYdAJAJPM';
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;

        $menu=[
            "button" => [
                [
                    "type"=>"click",
                    "name"=>"CURL",
                    "key"=>"curl001"
                ]
            ]
        ];

        //初始化
        $ch=curl_init($url);

        //设置参数
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //POST请求
        curl_setopt($ch,CURLOPT_POST,true);
        //发送json数据 form-data形式
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($menu));

        //执行curl会话
        $response=curl_exec($ch);

        //获取错误
        $errno=curl_errno($ch);
        $error=curl_error($ch);
        if($errno>0) //有问题
        {
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息：".$error;die;
            die;
        }

        //关闭会话
        curl_close($ch);

        //数据处理
        var_dump($response);
    }




    public function guzzle1(){
        $app_id='wx0079197aeab14faf';
        $appsecret='e76097268baf9e05fed3c7d35c1430ab';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret.'';
//        echo $url;

        $client=new Client();
        $response=$client->request('GET',$url);
        $data=$response->getBody();  //获取服务器响应的数据
        echo $data;
//        dd($response);
    }

    public function guzzle2(){
    }




    public function get1(){
        echo "<pre>";print_r($_GET);echo "</pre>";
    }

    public function post1(){
        echo '<hr>';
        echo "我是api 开始";
        echo "<pre>";print_r($_POST);echo "</pre>";
        echo "<pre>";print_r($_FILES);echo "</pre>";
        echo "我是api 结束";
    }

    public function post2(){
        echo "<pre>";print_r($_POST);echo "</pre>";
    }

    //接收 json xml
    public function post3(){
        $data=file_get_contents("php://input"); //接收 json 或者xml 字符串
        echo $data;
        "<hr>";
        $arr=json_decode($data,true);
        echo  "<pre>";print_r($arr);echo "</pre>";

    }


    //接收post上传文件
    public function testUpload(){
        echo  "<pre>";print_r($_POST);echo "</pre>";
        echo  "<pre>";print_r($_FILES);echo "</pre>";
    }

    public function getUrl(){
        //协议http https
        $scheme=$_SERVER['REQUEST_SCHEME'];

        //域名
        $host=$_SERVER['HTTP_HOST'];

        //请求urt
        $uri=$_SERVER['REQUEST_URI'];

        $url=$scheme . '://' . $host . $uri;

        echo '当前URL ： '.$url;echo '<hr>';

        echo "<pre>";print_r($_SERVER);echo "</pre>";
    }

    public function RedisStr1(){
//        $key='name';
//        $val='liusir123123';
//
//        Redis::set($key,$val);


        $token='aasdasd';
        $key='user_token';
        //写入
        Redis::set($key,$token);

        //设置过期时间
        Redis::expire($key,300);
    }


    public function count1(){
        //使用ua识别用户访问
        $ua=$_SERVER['HTTP_USER_AGENT'];
        $u=md5($ua);
        $u=substr($u,5,5);

        //访问次数限制
        $limit=env('API_ACCESS_COUNT');
        //访问次数是否上线
        $key=$u . ':count1';
        $number=Redis::get($key);
        echo "访问次数".$number;echo "<br>";

        //超过访问上线
        if($number>$limit){
            $tout=env('API_TIMEOUT_SECOND');  //禁止访问时间
            Redis::expire($key,$tout);
            echo "访问次数已超过" . $limit;echo "<br>";
            echo $tout.'秒后在访问';echo "<br>";
            die;
        }
        $count=Redis::incr($key);
        echo $count;
        echo "正常";
    }


    public function api2(){
        $ua=$_SERVER['HTTP_USER_AGENT'];
        $u=md5($ua);
        $u=substr($u,5,5);

        //获取当前访问的uri
        $uri=$_SERVER['REQUEST_URI'];
        $md5_uri=substr(md5($uri),0,8);
        $key='count:uri:'.$u.':'.$md5_uri;
        echo $key;echo "<br>";
        echo "<hr>";
        $count=Redis::get($key);
        echo "当前接口数" . $count;echo "<br>";
        $max=env('API_ACCESS_COUNT');   //接口访问限制
        echo "接口访问最大次数" . $max;echo "<br>";
        if($count>$max){
            echo "你刷接口啊兄嘚";
            die;
        }
        Redis::incr($key);

    }

    public function api3(){
        $ua=$_SERVER['HTTP_USER_AGENT'];
        $u=md5($ua);
        $u=substr($u,5,5);

        //获取当前访问的uri
        $uri=$_SERVER['REQUEST_URI'];
        $md5_uri=substr(md5($uri),0,8);
        $key='count:uri:'.$u.':'.$md5_uri;
        echo $key;
    }

    public function md5Test1(){
        $key='uzi';
        $data=$_GET['data'];
        echo $data; echo "<br>";

        $number=md5($data.$key);
        echo "签名".$number;
    }

    public function md5Test2(){
        $key='uzi';
        $data=$_GET['data']; //接收数据
        $number=$_GET['number']; //接收签名

        //验证签名 与发送端的签名相同规则
        $number2=md5($data.$key);
        echo "接收的签名".$number2;echo "<br>";

        //与接收到的签名对比判断
        if($number2 == $number){
            echo "验证签名通过";
        }else{
            echo "验证签名失败";
        }
    }

    public function decrypt(){
        echo '123';
    }



    public function decrypt1(){
//        $method_arr=openssl_get_cipher_methods();
//        echo "<pre>";print_r($method_arr);echo "</pre>";
//        die;
//        $data='hello'; //要加密的数据
//        $method='';  //要的加算法

        $key='666';
        $method='aes-128-cbc';   //加算法
        $iv='abcdefg1234zxcdf';  //必须为16个
        echo "<hr>";
        echo "接受到数据:";echo "<br>";
        echo "<pre>";print_r($_GET);echo "</pre>";
        $data=$_GET['data'];

        $enc_str=base64_decode($data);

        //解密
        $dec_data=openssl_decrypt($enc_str,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo "解密数据：";echo "<br>";
        var_dump($dec_data);
    }

}
