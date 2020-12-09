<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Organization;
use App\Playlist;
use App\Song;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\GuardResolver;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource for currently logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GuardResolver $guard, $id)
    {
        $user = $guard->user();
        $playlists = $user->playlists;


        if (Auth::guard('teacher')->check()) {
            $classrooms = $user->classrooms;

            foreach ($classrooms as $classroom) {
                $playlists = $playlists->merge($classroom->playlists);
            }
        }

        
        return response()->json($playlists, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, GuardResolver $guard)
    {  
        $user = $guard->user();

        $playlist = $user->playlists()->create($request->all());
        return response()->json($playlist, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        return response()->json($playlist);
    }

    public function showSongs(Playlist $playlist)
    {
        return response()->json($playlist->songs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        $playlist->update($request->all());
        return response()->json(null, 201);
    }

    public function attachSongToPlaylist(Playlist $playlist, Song $song)
    {
        if($playlist->songs->contains($song)) {
            return response()->json(['message' => 'song has already been added']);
        } 
        
        return $playlist->songs()->attach($song->id);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $playlist = Playlist::find($id);
        $playlist->delete();
        return response()->json(null, 201);
    }

    public function getTeacherPlaylists()
    {
        $playlists = Auth::guard('teacher')->user()->playlists;
        return response()->json($playlists);
    }

}
