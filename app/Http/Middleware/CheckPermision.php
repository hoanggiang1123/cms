<?php
 namespace App\Http\Middleware;
 use Closure;

 class CheckPermision {

    public function handle($request, Closure $next)
    {
        if ( ! check_user_permision($request)) {
            abort(403, "Forbidden access!");
        }

        return $next($request);
    }
 }