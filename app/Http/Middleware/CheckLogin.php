<?php
 namespace App\Http\Middleware;
 use Closure;

 class CheckLogin {

    public function handle($request, Closure $next)
    {
        if($request->session()->has('userInfo')) {

            return redirect()->route('post');
        }
        
        return $next($request);
    }
 }