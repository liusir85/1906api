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
}
