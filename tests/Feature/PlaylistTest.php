<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Playlist;

class PlaylistTest extends TestCase
{

    use RefreshDatabase;

    protected $baseUrl = '/playlists/';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function a_playlist()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_a_playlist_can_be_created()
    {
         // $this->withoutExceptionHandling();
         $this->beforeEach();
        $response = $this->authRequest($this->baseUrl, 'post', [
            'name' => 'playlist'
        ]);
        $playlist = Playlist::all()->first();
        $this->assertEquals(1, $playlist->id);
        $response->assertStatus(201);
    }

    public function test_a_collection_of_playlist_by_user_can_be_indexed()
    { 
        // $this->withoutExceptionHandling();
        $this->beforeEach();
        $response = $this->authRequest($this->baseUrl);
        $response->assertStatus(200);

    }

    //TODO
    // public function a_playlist_can_be_shown() 
    // {

    // }

    // public function a_playlist_has_a_name_set()
    // {

    // }


    // public function a_song_can_be_added_to_playlist()
    // {

    // }

    // public function a_playlist_can_be_updated()
    // {

    // }

    // public function a_playlist_can_be_destroyed()
    // {

    // }

    // public function a_playlist_relationships_can_be_destroyed_on_delete()
    // {

    // }

     protected function authRequest($url, $method = 'GET', $data  = null) 
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
