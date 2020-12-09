<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Teacher extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function classrooms()
    {
        return $this->hasMany('App\Classroom');
    }

    public function playlists()
    {
        return $this->morphToMany('App\Playlist', 'playlistable');
    }

    public function createPlaylist($name)
    {
        return $this->playlists()->create([
            'name'=> $name
        ]);
    }

    public function createClass($name)
    {
        $this->classrooms()->create([
            'name'=> $name
        ]);
    }

    public function loggedIn()
    {
        return $this->update(['first_login' => 1]);
    }

    public function isActive()
    {
        return $this->organization->isActive();
    }

    public function hashPassword($request)
    {
        $this->update(['password' => Hash::make($request->password)]);
    }

    public function belongsToOrganization() {
        return true;
    }

    public function isUser(){
        return false;
    }

}
