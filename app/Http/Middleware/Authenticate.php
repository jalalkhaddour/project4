<?php

namespace App\Http\Middleware;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $token1=explode(' ',$request->header('Authorization'));
        $token=$token1[1];
        //dump($token);
        $perToken=PersonalAccessToken::findToken($token);
        $user=User::findOrFail($perToken->tokenable_id);
        Auth::login($user);

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
