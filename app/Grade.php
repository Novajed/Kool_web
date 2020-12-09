<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function songs()
    {
        return $this->belongsToMany('App\Song');
    }

    public function songsWhere()
    {

    }
}
