<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $domains = ['http://localhost:8081'];
        if(isset($request->server()['HTTP_ORIGIN'])){
           $orgins = $request->server()['HTTP_ORIGIN'];
            if(in_array($orgins,$domains)){
                header('Access-Control-Allow-Origin: '.$orgins);
                header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');

            }
        }

        return $next($request);
    }
}
