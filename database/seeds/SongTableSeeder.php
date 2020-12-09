<?php

use Illuminate\Database\Seeder;
use App\Song;
use App\Grade;

class SongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\Song::class,100)
    		->create()
    		->each(function($song) {
    			Grade::find(rand(1,13))->songs()->attach($song->id);
    	});
    }
}
