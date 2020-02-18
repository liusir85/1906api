<?php

namespace App\Http\Controllers;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Model\PgoodsModel;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    public function shop(Request $request){

        $goods_id = request()->input('goods_id');       //商品id
        $goods_key = 'str:goods:info:'.$goods_id;
        echo 'redis_key: '.$goods_key;echo "<br>";

        //判断是否有缓存信息
        $cache = Redis::get($goods_key);

        if($cache){
            echo "有缓存:";echo "<br>";
            $goods_info = json_decode($cache,true);
            echo "<pre>";print_r($goods_info);echo "</pre>";
        }else{
            echo "无缓存:";echo "<br>";
            //求数据库中取数据,并保存到缓存中
            $goods_info = GoodsModel::where(['id'=>$goods_id])->first();
            $arr = $goods_info->toArray();

            $j_goods_info = json_encode($arr);
            Redis::set($goods_key,$j_goods_info);
            Redis::expire($goods_key,5);
            echo "<pre>";print_r($arr);echo "</pre>";
        }

        die;





        $id=$request->input('id');
        $goods_id=$request->get('goods_id');
        echo "goods_id:" . $goods_id;echo "<br>";
        echo "商品名：hello";echo "<hr>";

        $ua=$_SERVER['HTTP_USER_AGENT'];
        $ip=$_SERVER['REMOTE_ADDR'];
        $time=time();
        $data=[
            'id'=>$id,
            'goods_id'=>$goods_id,
            'ua'=>$ua,
            'ip'=>$ip,
            'time'=>$time
        ];
        $res=GoodsModel::insertGetId($data);

        //计算机统计信息
        $res=GoodsModel::where(['goods_id'=>$goods_id])->count(); //计算pv
        echo "当前ip" . $res;echo "<br>";

        //TODO Laravel model 去重
        $uv=GoodsModel::where(['goods_id'=>$goods_id])->distinct('ua')->count('ua');
        echo "当前ua" . $uv;echo "<br>";
    }
}
