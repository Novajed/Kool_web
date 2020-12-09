<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function playlists()
    {
        return $this->morphToMany('App\Playlist', 'playlistable');
    }

    public function createPlaylist()
    {
        return $this->playlists()->create();
    }

}
