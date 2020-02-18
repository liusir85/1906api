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
//        echo $ua;echo "<br>";
        $u=md5($ua);
//        echo "md5ua" . $u;echo "<br>";
        $u=substr($u,5,5);
//        echo "u:".$u;die;

        //访问次数限制
        $limit=env('API_ACCESS_COUNT');
//        echo $limit;die;
        //访问次数是否上线
//        echo $u;die;
        $key=$u . ':count1';
//        echo $key;die;
        $number=Redis::get($key);

        echo "访问次数".$number;echo "<br>";

        if($number>$limit){
            echo "访问次数已超过" . $limit;
            die;
        }
        $count=Redis::incr($key);
        echo $count;
        echo "正常";
    }
}
