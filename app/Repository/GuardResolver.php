<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;


class GuardResolver {
    public function user()
    {
        $user                 = Auth::user();
        $user == null ? $user = Auth::guard('teacher')->user() : '';
        $user == null ? $user = Auth::guard('organization')->user() : '';
        $user == null ? $user = Auth::guard('admin')->user() : '';
        return $user;
    }

    public function home() {
        if (Auth::user()) {
            return 'user.home';
        } else if (Auth::guard('admin')->check()) {
            return 'admin.home';
        } else if (Auth::guard('teacher')->check()) {
            return 'teacher.home';
        } else if (Auth::guard('organization')->check()) {
            return 'organization.home';
        }
        return 'landing';
    }

    public function isLoggedIn() 
    {
        $guards = ['admin', 'teacher', 'organization' , ''];
        $authenticated = 0;
        foreach($guards as $g) 
        {
            if(Auth::guard($g)->check())
            {
                $authenticated++;
                break;
            }
        }
        if ($authenticated > 0) {
            return true;
        }
        return false;
    }

    public function getHomeUrl() {
        if (Auth::user()) {
            return '/home';
        } else if (Auth::guard('admin')->check()) {
            return '/admin/home';
        } else if (Auth::guard('teacher')->check()) {
            return '/portal/home';
        } else if (Auth::guard('organization')->check()) {
            return '/club/home';
        }
        return '/';
    }
    //get user with id
    public function getUser($id)
    {
        if (Auth::guard('admin')->check()) {
            return Admin::find($id);
        } else if (Auth::guard('teacher')->check()) {
            return Teacher::find($id);
        } else if (Auth::guard('organization')->check()) {
            return Organization::find($id);
        } else if (Auth::guard()->check()) {
            return User::find($id);
        }

    }

    //check if current logged in user belongs to guard
    public function is($guardName = null) {
        //if guard is user set $guardName to null
        strtolower($guardName) == 'user' ? $guardName = null : false;
        return Auth::guard($guardName)->check();
    }

}