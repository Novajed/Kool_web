<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Repository\GuardResolver;

class InactiveMiddleware
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
        $guard = new GuardResolver();

        $user = $guard->user();
        if (method_exists($user, 'isActive')) {
            if($user->isActive()) {
                return redirect(route($guard->home()));
            }
            return $next($request);
        }
        return $next($request);
    }
}
