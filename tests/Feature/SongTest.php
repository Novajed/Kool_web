<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Song;
use app\Grade;

class SongTest extends TestCase
{

    use RefreshDatabase;

    protected $baseUrl = '/songs/';

    public function test_songs_can_be_indexed()
    {
        $this->beforeEach();
        $response = $this->authRequest($this->baseUrl);

        $song = json_decode($response->getContent())[0];

        $this->assertEquals(1, $song->id);
        $this->assertEquals(Song::find(1)->title, $song->title);
    }



    public function test_a_song_can_be_shown()
    {
        $this->beforeEach();
        $song = factory(Song::class)->create();

        $response = $this->authRequest($this->baseUrl . $song->id);

        $this->assertEquals($song->id, json_decode($response->getContent())->id);
    }


    public function test_songs_can_be_browsed()
    {
        $this->beforeEach();

        Grade::find(3)->songs()->attach(1);
        Song::find(1)->update(['subject_id' => 2]);
        $response = $this->authRequest('/api/grade/3/subject/2');

        $song = collect(json_decode($response->getContent()))->first();
        $this->assertEquals(2, $song->subject_id);
        $this->assertEquals(3,$song->pivot->grade_id);
        

    }

    public function test_songs_can_be_queried_by_title()
    {
        $this->beforeEach();
        $song = factory(Song::class)->create([
            'title' => 'qwertyuiop1234567890',
        ]);

        $response = $this->query('qwertyuiop1234567890');

        $this->assertEquals($song->id, collect(json_decode($response->getContent()))->first()->id);

    }

    public function test_only_admins_can_add_songs()
    {
        $this->beforeEach();

        $response = $this->authRequest($this->baseUrl,'post',
         [
            'title' => 'qwertyuiop123456789',
            'subject_id' => '1',
        ]);
        $response->assertStatus(404);
    }


    protected function  query($query)
    {
        $this->beforeEach();
        $response = $this->authRequest('/api/search','post',[
                'qry' => $query
             ]);
        return $response;
    }


    protected function authRequest($url, $method = null, $data  = null) 
    {
        $user = factory(User::class)->create();

        strtoupper($method) == 'GET' || $method == null ? $response = $this->actingAs($user)->get($url) : false;

        strtoupper($method) == 'POST' ? $response = $this->actingAs($user)->post($url,$data) : false;

        strtoupper($method) == 'PUT' || strtoupper($method) == 'PATCH' ? $response = $this->actingAs($user)->put($url,$data) : false;

        strtoupper($method) == 'DELETE' ? $response = $this->actingAs($user)->delete($url) : false;

        return $response;
    }


    protected function beforeEach($except = [])
    {
        $this->withoutMiddleware(\App\Http\Middleware\StatusMiddleware::class);
        $this->seed('GradeTableSeeder');
        $this->seed('SubjectsTableSeeder');
        $this->seed('SongTableSeeder');
    }




}
