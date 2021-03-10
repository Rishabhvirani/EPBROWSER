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
        $slug = request()->segment(count(request()->segments())-1) ."/". request()->segment(count(request()->segments()));
        $except = array(
            'users/register',
            'users/login',
            'users/forgot_password',
            'users/password_reset',
        );
        if(!in_array($slug,$except)){
            $token = $request->header('token');
            $count = UsersModel::where('api_token', $token)->count();
            if($count == 0){
                return response()->json(['message'=>'token issue']);
            }
        }
        return $next($request);
    }
}
