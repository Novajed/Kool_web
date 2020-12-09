<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function songs()
    {
        return $this->hasMany('App\Song');
    }
}
