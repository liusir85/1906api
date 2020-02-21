<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
class UserController extends Controller
{
    //获取用户信息 2020.2.12 10:00
    public function info(){
        $user_info=[
            'user_name'=>'liusir',
            'sex'=>1,
            'email'=>'893518673@qq.com',
            'age'=>'123',
            'date'=>date('Y:m:d H:i:s'),
//            'dada'=>'阿诗丹'
        ];
        return $user_info;
    }


    //用户注册
    public function reg(Request $request){
//        $data=$request->input();    //接收数据
//        $user_name=$request->input('user_name');
//        echo 'user_name:'.$user_name;
//        echo  "<pre>";print_r($data);echo "</pre>";

        $user_info=[
            'user_name'=>$request->input('user_name'),
            'email'=>$request->input('email'),
            'pass'=>'123asd',
        ];

        //入库
        $id=UserModel::insertGetId($user_info);
        echo "用户ID：".$id;
    }

    public function weather(){
        if(empty($_GET['location'])){
            echo "请输入城市名称";die;
        }

        $location=$_GET['location'];   //客户端传递的参数
        //请求第三方接口  天气接口
        $url='https://free-api.heweather.net/s6/weather/now?location='.$location.'&key=626278c5cabf4f09835d91daec5c91e0';
        $data=file_get_contents($url);
        $arr=json_decode($data,true);
        echo "<pre>";print_r($arr);echo "</pre>";

        return $data;
    }
}
