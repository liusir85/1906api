<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class ApiFilter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uri=$_SERVER['REQUEST_URI'];
        $ua=$_SERVER['HTTP_USER_AGENT'];

        $u=md5($ua);
        $u=substr($u,5,5);
        $md5_uri=substr(md5($uri),0,8);

        $key='count:uri:'.$u.':'.$md5_uri;

        $count=Redis::get($key);
        echo "当前接口数" . $count;echo "<br>";
        $max=env('API_ACCESS_COUNT');   //接口访问限制
        if($count>$max){
            echo "你刷接口啊兄嘚";
            //设置过期时间
            Redis::expire($key,env('API_TIMEOUT_SECOND'));
            die;
        }
        Redis::incr($key);
        echo"<hr>";echo "<br>";

        return $next($request);
    }
}
