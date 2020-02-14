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
});


Route::prefix('/Api')->group(function (){
    Route::get('/info','Api\UserController@info');
    Route::post('/reg','Api\UserController@reg');  //用户注册
});