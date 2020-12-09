<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password', 'first_login', 'grade', 'is_active',
    ];

    /**
     * The attributes that should be hidden for array
     *
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
        return $this->belongsToMany('App\Classroom');
    }

    public function playlists()
    {
        return $this->morphToMany('App\Playlist', 'playlistable');
    }

    public function attachToOrganization($organization_id) 
    {
        if(empty($this->organization_id)) {
            $organization = Organization::findOrFail($organization_id);
            if($organization) {
                $this->organization_id = $organization_id;
                return true;
            }
        }
        return false;
    }

    public function createPlaylist()
    {
        return $this->playlists()->create();
    }

    public function updateName($name)
    {
        return $this->update(['name' => $name]);
    }

    public function belongsToOrganization() {
        return $this->organization()->exists();
    }

    public function setGrade($grade)
    {
        return $this->update(['grade' => $grade]);
    }

    public function loggedIn()
    {
        return $this->update(['first_login' => 1]);
    }

    public function joinClass($class_id)
    {
        return $this->classrooms()->attach($class_id);
    }

    public function leaveClass($class_id)
    {
        return $this->classrooms()->detach($class_id);
    }

    public function isActive()
    {
        return $this->belongsToOrganization() ?
        $this->organization->isActive() :
        $this->is_active;
    }

    public function isUser(){
        return true;
    }

    public function hashPassword($request)
    {
        $this->update(['password' => Hash::make($request->password)]);
    }

     public function activate()
    {
        return !$this->belongsToOrganization() ?
        $this->update(['is_active' => 1]):
        false;
    }

    public function deactivate()
    {
        return !$this->belongsToOrganization() ?
        $this->update(['is_active' => 0]):
        false;
    }

}
