<?php

namespace App\Repository;

use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticator
{
    public function login(Request $request, $guard)
    {
        $route = "{$guard}.home";

        //get credentials
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];
        // attempt to log the user in

        if (Auth::guard($guard)->attempt($credentials, $request->remember)) {
            //if successful, redirect to their intended location
            return redirect()->intended(route($route));

        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }



    public function register(Request $request, $guard = null)
    {
        $guard == null ?
        $guard = $request->guard :
        false;
        $route = '';
        if ($request->filled('access_code')) {
            $organization = Organization::find($request->access_code);
            switch($guard) {
                case 'user':
                    $user         = $organization->users()->create($request->all());
                    $route = 'home';
                    break;
                case 'teacher':
                    $user = $organization->teachers()->create($request->all());
                    $route = 'teacher.home';
                    break;
            }
            
        } else {
            $user            = \App\User::create($request->all());
            $user->deactivate();
            $route = 'payment';
        }

        $user->hashPassword($request);
        return $route;
    }

}
