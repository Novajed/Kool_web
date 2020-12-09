<?php

namespace App\Http\Middleware;

use Closure;
use App\Organization;

class AllowRegisterStudent
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
        $organization = Organization::find($request->access_code);

        if (!$organization->canRegisterStudent()) {
            return back()->withErrors(['message' => 'Please Contact Administrator.']);
        }

        return $next($request);
    }
}
