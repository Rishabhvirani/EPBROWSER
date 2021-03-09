<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use \App\Models\UsersModel;

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

        if( $request->is('api/register') || $request->is('api/login')){
            return $next($request);
        }
        $token = $request->header('token');
            $count = UsersModel::where('api_token', $token)->count();
            if($count == 0){
                return response()->json(['message'=>'token issue']);
            }

        
        return $next($request);
    }
}
