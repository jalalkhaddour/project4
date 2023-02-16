<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Route;

class permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {    $perurl=Route::currentRouteAction();
        $pers=explode('@',$perurl);
        if(array_key_exists(1,$pers)){
            $per=$pers[1];}else{
            $per=$pers[0];
        }
        $authGuard = Auth::guard($guard);
        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        $user=$request->user();
        $userpers=$user->AllPermissions();


        if (! in_array($per,$userpers)) {

            throw UnauthorizedException::forPermission($per);
        }

        return $next($request);
    }
}