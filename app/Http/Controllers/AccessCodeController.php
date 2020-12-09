<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Http\Requests\AccessCodeRequest;
use \App\Http\Requests\RegisterRequest;
use App\Repository\Authenticator;

class AccessCodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
 
    /**
     * handle an access code request
     *
     * @param Request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function accessCodeRequest(AccessCodeRequest $request)
    {
        //resolve guard from HTTP_REFERRER
        $guard      = $this->resolveGuard($request);
        $accesscode = $request->access_code;
        return redirect(url('registration/' . $guard . '/' . $accesscode));
    }

    /**
     * Show the register form.
     *
     * @param access code, guard
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showRegisterForm($guard = null, $accesscode = null)
    {
        return view('register', ['guard' => $guard, 'access_code' => $accesscode]);
    }

    public function register(RegisterRequest $request)
    {
        $authenticator = new Authenticator;
        $guard = $request->guard;
        $route = $authenticator->register($request, $guard);
        //get credentials
        $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
            ];
            //ifbelongs to organizationredirect route is {guard}.home
        if ($request->filled('access_code')) {
            $route = "{$guard}.home";

            // attempt to log the user in
            $guard == 'user' ? $guard = null : false;
            if (Auth::guard($guard)->attempt($credentials, $request->remember)) {
                //if successful, redirect to their intended location
                return redirect(route($route));
            }
            return redirect()->back()->withInput($request->only('email', 'remember'));
        }
        Auth::guard($guard)->attempt($credentials, $request->remember);
        return redirect(route($route));

    }

    /**
     * check http refferrer to resolve guard
     *
     * @param Request
     * @return String $guard
     */
    protected function resolveGuard(Request $request)
    {
        $referrer   = $request->server('HTTP_REFERER');
        $teacherUrl = $request->server('HTTP_ORIGIN') . '/portal';
        if ($referrer == $teacherUrl) {
            return 'teacher';
        }
        return 'user';
    }
}
