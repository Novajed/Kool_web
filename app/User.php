<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','first_login','grade'
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

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function classrooms(){
        return $this->belongsToMany('App\Classroom');
    }

    public function playlists(){
        return $this->morphToMany('App\Playlist','playlistable');
    } 

    public function createPlaylist(){
        return $this->playlists()->create();
    }


    public function updateName($name){
        return $this->update(['name' => $name]);
    }

    public function setGrade($grade){
        return $this->update(['grade' => $grade]);
    }

    public function loggedIn(){
        return $this->update(['first_login' => 1]);
    }

    public function joinClass($class_id){
        return $this->classrooms()->attach($class_id);
    }

    public function leaveClass($class_id){
            return $this->classrooms()->detach($class_id);
    }

    public function isActive(){
        return $this->organization_id == null ?
         $this->is_active :
         $this->organization->isActive();
    }

    public function hashPassword($request){
        $this->update(['password' => Hash::make($request->password)]);
    }
}
