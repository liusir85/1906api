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
Route::get('/phpinfo', function () {
   phpinfo();
});

////测试redis   路由
//Route::get('/test/redis','TestController@testRedis');
//////////////////////////

Route::prefix('/test')->group(function (){
    //测试redis   路由
    Route::get('/redis','TestController@testRedis');
    Route::get('/wx/token','TestController@getAccessToken');
    Route::get('/wx/curl1','TestController@curl1');
    Route::get('/wx/guzzle1','TestController@guzzle1');

    Route::get('/wx/curl2','TestController@curl2');
    Route::get('/wx/guzzle2','TestController@guzzle2');

    Route::get('/wx/get1','TestController@get1');     //处理get接口请求
    Route::post('/wx/post1','TestController@post1');     //处理post接口请求
    Route::post('/wx/post2','TestController@post2');     //处理post接口请求
    Route::post('/wx/post3','TestController@post3');     //处理post接口请求

    Route::post('/wx/upload','TestController@testUpload');     //处理post上传文件
    Route::get('/wx/geturl','TestController@getUrl');

    Route::get('/redis/str1','TestController@RedisStr1');

    Route::get('/redis/count1','TestController@count1');
});


Route::prefix('/Api')->group(function (){
    Route::get('/info','Api\UserController@info');
    Route::post('/reg','Api\UserController@reg');  //用户注册
});


Route::prefix('/goods')->group(function (){
    Route::get('/shop','GoodsController@shop');
});
