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

        //执行会话
        curl_exec($ch);

        //关闭会话
        curl_close($ch);
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
}
