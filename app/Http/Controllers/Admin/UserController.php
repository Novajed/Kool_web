<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use app\Organization;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return response()->json(null, 204);
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    public function massStore(Request $request, Organization $organization)
    {
        $count    = $request->count;
        $start_id = User::orderBy('id', 'desc')->first()->id + 1;
        for ($i = $start_id; $i <= $count; $i++) {
            $organization->users()->create([
                'name'     => 'student' . $i,
                'email'    => 'student' . $i . '@koolriculum.com',
                'password' => '$2y$10$.WEiuHrXVaWIrpdp711GC.tmTfb582jzrUyZulAfDGF/4h2ZpWIha', //abc1234
            ]);
            return response()->json(null, 201);
        }
    }
}
