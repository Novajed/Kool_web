<?php

namespace App\Http\Middleware;

use Closure;

class StatusMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user is active.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if($request->user()) {
        $user = $request->user();
        //if user belongs to an organization
            if($user->belongsToOrganization()){
               if($user->organization->isActive()){
                return $next($request);
               }
             return redirect(route('inactive'));
            }
        //if user doesn't belong to an organization
            else{
                if($user->isActive()) {
                    return $next($request);
                }
                return redirect(route('payment'));
            }
       }

        return $next($request);

    }
}

