<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'standard', 'tags', 'month', 'week', 'subject_id', 'src', 'thumbnail_src',
    ];

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function grades()
    {
        return $this->belongsToMany('App\Grade');
    }

    public function incrementViews(){
        $this->increment('views');
    }

}
