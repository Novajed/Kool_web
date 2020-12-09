<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\GuardResolver;

class APIController extends Controller
{
    public function user(GuardResolver $guard)
    {
        return response()->json($guard->user());
    }

}
