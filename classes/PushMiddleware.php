<?php namespace Infoadvisor\Push\Classes;

use App;
use Closure;
use Config;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class PushMiddleware{


    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $cookie = Cookie::get('assets_pushed');
        if($cookie == null){
            $cookie=[];
        }

        else{
            $cookie=json_decode($cookie,true);
        }

        $cookie=[];

        $service=App::make('push');

        $pushes=$service->listData();

//        $newPushes=array_diff_assoc($cookie,$pushes);


        $pushString=[];

        foreach($pushes as $k=>$v){
            if(!array_key_exists($k,$cookie)){
                $str="<".$k.">; rel=preload;";

                if(ends_with($k,'.css')){
                    $str.=' as=style';
                }

                else if(ends_with($k,'.js')){
                    $str.=' as=script';
                }

                $cookie[$k]=$v;
                $pushString[]=$str;
            }
        };
        if(count($pushString)>0){
            $response->header('Link',implode(',',$pushString));
            $response->withCookie(Cookie::make('assets_pushed', json_encode($cookie),2592000));
        }
        return $response;
    }
}
