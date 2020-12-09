<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function test_guest_user_can_navigate_to_register_page()
    {
        // $this->withoutExceptionHandling();
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_guest_user_can_navigate_to_login_page()
    {
        // $this->withoutExceptionHandling();
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_be_registered()
    {
        // $this->withoutExceptionHandling();  
        $response = $this->post('/register', [
            'name' => 'tommy woods',
            'email'=> 'tommy.oods@gmail.com',
            'password' => 'abc123456',
            'password_confirmation' => 'abc123456',
        ]);
        $user = \App\User::find(1);
        $this->assertEquals($user->isActive(), 0);
        $this->assertFalse($user->belongsToOrganization());
        $response->assertRedirect('/payment');
    }

    public function test_access_code_request_for_student() 
    {
        // $this->withoutExceptionHandling();
        $organization = factory(\App\Organization::class)->create(['id' => 500344]);
        $response = $this->post('/registration/access-code', [
            'guard'=> 'user',
            'name' => 'tommy woods',
            'email'=> 'tommy.woods@gmail.com',
            'password' => 'abc123456',
            'password_confirmation' => 'abc123456',
            'access_code' => 500344,
        ]);
        $user = \App\User::find(1);
        $this->assertEquals(empty($user), false);
        $this->assertEquals($user->isActive(), 1);
        $this->assertTrue($user->belongsToOrganization());
        $this->assertEquals($organization->users->first()->id, 1);
        $response->assertRedirect('/home');    
    }


    public function test_student_can_be_register()
    {   
        $organization = factory(\App\Organization::class)->create(['id' => 5003]);

         $this->withoutExceptionHandling();
        $response = $this->post('/register', [
            'name' => 'tommy woods',
            'email'=> 'tommy.woods@gmail.com',
            'password' => 'abc123456',
            'password_confirmation' => 'abc123456',
            'access_code' => 5003,
        ]);

        $user = \App\User::find(1);
        $this->assertEquals($user->isActive(), 1);
        $this->assertTrue($user->belongsToOrganization());
        $this->assertEquals($organization->users->first()->id, 1);
        $response->assertRedirect('/home');
    }
    //TODO
    public function test_user_can_login()
    {
        // $this->withoutExceptionHandling();
        $this->beforeEach();
        $user = factory(User::class)->create(['password' => 'abc12345678']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'abc12345678'
        ]);
        dd($user);
        $response->assertRedirect('/home');
    }

    // public function test_user_name_can_be_updated()
    // {

    // }

    // public function test_user_can_create_playlists()
    // {

    // }

    // public function test_user_can_join_classroom()
    // {

    // }

    protected function authRequest($url, $method = null, $data  = []) 
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

