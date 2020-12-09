<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_login', 'grade',
    ];

    protected $guard = 'admin';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function organizations()
    {
        return App\Organization::all();
    }

    public function users()
    {
        return App\User::all();
    }

    public function teachers()
    {
        return App\Teacher::all();
    }

    public function songs()
    {
        return App\Song::all();
    }

    public function playlists()
    {
        return $this->morphToMany('App\Playlist', 'playlistable');
    }

     public function isUser(){
        return false;
    }

    public function belongsToOrganization(){
        return false;
    }

    public function isActive(){
        return true;
    }

}
