<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Playlist;
use App\User;
use Auth\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('teacher')->check()) 
        {
            Auth::guard('teacher')->user()->classrooms()->create($request->all);
        }
        return response()->json(null,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Classroom::find($id)->delete();
        return response()->json(null,201);
    }

    public function getClassrooms($user_id) 
    {
        $classrooms = $this->getUser($user_id)->classrooms;
    }

    public function getPlaylists($classroom_id) 
    {
        $playlists = Classroom::find($classroom_id)->playlists;
        return response()->json($playlists);
    }

    public function attachPlaylist($classroom_id,$playlist_id)
    {
        $classroom = Classroom::find($classroom_id);
        $playlist = Playlist::find($playlist_id);
        if (!$classroom->playlists->contains($playlist))
        {
            $classroom->playlists()->attach($playlist_id);
        }
    }

    public function detachPlaylist($classroom_id,$playlist_id)
    {
        $classroom = Classroom::find($classroom_id);
        $playlist = Playlist::find($playlist_id);
        if ($classroom->playlists->contains($playlist))
        {
            $classroom->playlists()->detach($playlist_id);
        }
    }

    public function createPlaylist(Request $request, $classroom_id)
    {
        $classroom = Classroom::find($classroom_id);
        $classroom->playlists()->create($request->all());
    }

    public function getAvailableStudents()
    {
        if (Auth::guard('teacher')->check())
        {
            $teacher = Auth::guard('teacher')->user();
            $students = $teacher->organization->students;
            return response()->json($students);
        }
    }

    public function addStudents(Request $request,$classroom_id)
    {
        $classroom = Classroom::find($classroom_id);
        foreach ($request->students as $student_id)
        {
            $user = User::find($student_id);
            if (!$classroom->users->contains($user)) 
            {
                $classroom->users()->attach($student_id);
            }
        }
    }

    public function removeStudent($classroom_id,$student_id)
    {
        $classroom = Classroom::find($classroom_id);
        $user = User::find($student_id);
        if ($classroom->users->contains($user)) 
        {
            $classroom->users()->detach($student_id);
        }


    }

    protected function getUser($id)
    {
        if (Auth::guard('admin')->check()) {
            return Admin::find($id);
        }
        else if (Auth::guard('teacher')->check()) {
            return Teacher::find($id);
        }
        else if (Auth::guard('organization')->check()) {
            return Organization::find($id);
        }
        else if (Auth::guard()->check()) {
            return User::find($id);
        }

    }
}
