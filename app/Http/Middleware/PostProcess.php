<?php

namespace App\Http\Middleware;
use Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PostProcess {

    public function handle($request, $next) {
        $user = Auth::user();
        //dd($user);
        if(!empty($user)){
            Helper::addToLog("", $user->id, json_encode($_REQUEST));
        }else{
            Helper::addToLog("", "0", json_encode($_REQUEST));
        }
        return $next($request);
        
    }
}
