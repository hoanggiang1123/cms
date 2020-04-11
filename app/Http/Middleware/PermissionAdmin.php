<?php
namespace App\Http\Middleware;
use Closure;

class PermissionAdmin {

    public function handle($request, Closure $next)
    {
        if($request->session()->has('userInfo')) {
            $userInfo = $request->session()->get('userInfo');

            if($userInfo['level'] == 'Admin') return $next($request);
            return redirect()->route('dashboard');
           
        }
        return redirect()->route('dashboard');
    }
}