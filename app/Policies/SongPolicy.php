<?php

namespace App\Policies;

use App\Repository\GuardResolver;
use App\Song;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class SongPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the guard can view the song.
     *
     * @param  \App\GuardResolver  $guard
     * @param  \App\Song  $song
     * @return mixed
     */
    public function view(GuardResolver $guard, Song $song)
    {
        //
    }

    /**
     * Determine whether the guard can create songs.
     *
     * @param  \App\GuardResolver  $guard
     * @return mixed
     */
    public function create(GuardResolver $guard)
    {
        return $guard->is('admin'); 
    }

    /**
     * Determine whether the guard can update the song.
     *
     * @param  \App\GuardResolver  $guard
     * @param  \App\Song  $song
     * @return mixed
     */
    public function update(GuardResolver $guard, Song $song)
    {
        //
    }

    /**
     * Determine whether the guard can delete the song.
     *
     * @param  \App\GuardResolver  $guard
     * @param  \App\Song  $song
     * @return mixed
     */
    public function delete(GuardResolver $guard, Song $song)
    {
        //
    }

    /**
     * Determine whether the guard can restore the song.
     *
     * @param  \App\GuardResolver  $guard
     * @param  \App\Song  $song
     * @return mixed
     */
    public function restore(GuardResolver $guard, Song $song)
    {
        //
    }

    /**
     * Determine whether the guard can permanently delete the song.
     *
     * @param  \App\GuardResolver  $guard
     * @param  \App\Song  $song
     * @return mixed
     */
    public function forceDelete(GuardResolver $guard, Song $song)
    {
        //
    }
}
