<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authkey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        if( $request->is('api/register')){
            return $next($request);
        }
        $token = $request->header('token');
        print_R($token);
    

        if($token != 'token'){
            return response()->json(['message'=>'token issue']);
        }
        return $next($request);
    }
}
