<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Playlist;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\GuardResolver;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GuardResolver $guard)
    {
        $classrooms = $guard->user()->classrooms;
        return $classrooms->take(5);
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
        if (Auth::guard('teacher')->check()) {
            $teacher   = Auth::guard('teacher')->user();
            $classroom = $teacher->classrooms()->create($request->except(['students']));
            $this->addStudents($request, $classroom->id);
        }
        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classroom = Classroom::find($id);
        return response()->json($classroom);
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
        return response()->json(null, 201);
    }

    public function getClassrooms(GuardResolver $guard, $user_id)
    {
        $classrooms = $guard->user()->classrooms;
    }

    public function getClassroomsNoParams()
    {
        if (Auth::guard('teacher')->check()) {
            $teacher    = Auth::guard('teacher')->user();
            $classrooms = $teacher->classrooms;
            return response()->json($classrooms);
        }
    }

    public function getPlaylists($classroom_id)
    {
        $playlists = Classroom::find($classroom_id)->playlists;
        return response()->json($playlists);
    }

    public function getStudents($classroom_id)
    {
        $students = Classroom::find($classroom_id)->users;
        return response()->json($students);
    }

    public function attachPlaylist($classroom_id, $playlist_id)
    {
        $classroom = Classroom::find($classroom_id);
        $playlist  = Playlist::find($playlist_id);
        if (!$classroom->playlists->contains($playlist)) {
            $classroom->playlists()->attach($playlist_id);
        }
    }

    public function detachPlaylist($classroom_id, $playlist_id)
    {
        $classroom = Classroom::find($classroom_id);
        $playlist  = Playlist::find($playlist_id);
        if ($classroom->playlists->contains($playlist)) {
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
        if (Auth::guard('teacher')->check()) {
            $teacher  = Auth::guard('teacher')->user();
            $students = $teacher->organization->users;
            return response()->json($students);
        }
    }

    public function addStudents(Request $request, $classroom_id)
    {
        $classroom = Classroom::find($classroom_id);
        foreach ($request->students as $student_id) {
            $user = User::find($student_id);
            if (!$classroom->users->contains($user)) {
                $classroom->users()->attach($student_id);
            }
        }
    }

    public function removeStudent($classroom_id, $student_id)
    {
        $classroom = Classroom::find($classroom_id);
        $user      = User::find($student_id);
        if ($classroom->users->contains($user)) {
            $classroom->users()->detach($student_id);
        }

    }

}
