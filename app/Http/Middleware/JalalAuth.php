<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;


class JalalAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $token1=explode(' ',$request->header('Authorization'));
      // if(array_key_exists(1,$token1){
            $token=$token1[1];
        //}else{$token=$request->header('Authorization')}
        //dump($token);
        $perToken=PersonalAccessToken::findToken($token);
        $user=User::findOrFail($perToken->tokenable_id);
        Auth::login($user);
        $request->user=$user;
        return $next($request);
    }
}
