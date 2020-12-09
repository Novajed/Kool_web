<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Organization extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'subscription_id', 'is_active',
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

    public function teachers()
    {
        return $this->hasMany('App\Teacher');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function resolveGuard($guard)
    {
        return $guard == 'user' ? $this->users() : $this->teachers();
    }

    public function playlists()
    {
        return $this->morphToMany('App\Playlist', 'playlistable');
    }

    public function createPlaylist()
    {
        return $this->playlists()->create();
    }

    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }

    public function addTeacher($request)
    {
        $this->teachers()->create($this->teacherData($request));
    }

    public function addUser($request)
    {
        $this->users()->create($this->userData($request));

    }

    public function setSubscriptionLevel($id)
    {
        $this->update(['subscription_id' => $id]);
    }

    /*Check is user is active*/
    public function isActive()
    {
        return $this->is_active;
    }

    public function activate()
    {
        return $this->update(['is_active' => 1]);
    }

    public function deactivate()
    {
        return $this->update(['is_active' => 0]);
    }

    protected function teacherData($request)
    {
        return $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];
    }

    protected function userData($request)
    {
        return $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ];

    }

    public function generateAccessCode()
    {
        $code = rand(100000, 999999);
        if (!Organization::find($code)) {
            $this->update(['id' => $code]);
            return $code;
        }
        $this->generateAccessCode();
    }

    public function generateTeacherPasscode()
    {
        $code = rand(100000, 999999);
        $this->update(['teacher_passcode' => $code]);
        return $code;
    }

    public function hashPassword($request)
    {
        $this->update(['password' => Hash::make($request->password)]);
    }

    public function isUser(){
        return false;
    }

    public function belongsToOrganization() {
        return false;
    }

    public function canRegisterStudent()
    {
        return count($this->users) < $this->max_students; 
    }

    public function canRegisterTeacher()
    {
        return count($this->teachers) < $this->max_teachers;
    }

    
}
