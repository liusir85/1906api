<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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

    public function test1(){

    }
}
