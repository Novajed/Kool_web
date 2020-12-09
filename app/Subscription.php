<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function organizations()
    {
        return $this->hasMany('App\Organization');
    }
}
