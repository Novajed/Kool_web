<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\GuardResolver;

class DefaultController extends Controller
{
    public function index(GuardResolver $guard,$any)
    {
        return redirect($guard->getHomeUrl());
    }
}
