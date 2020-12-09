<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\GuardResolver;

class PaymentController extends Controller
{
    public function charge(GuardResolver $guard) {
    	$guard->user()->activate();
    	return redirect($guard->getHomeUrl());
    }
}
