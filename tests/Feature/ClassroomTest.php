<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassroomTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function a_classroom_can_be_created()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    //TODO
    // public function a_classroom_can_be_shown() 
    // {

    // }

    // public function a_classroom_can_be_deleted()
    // {

    // }

    // public function a_classrooms_relationship_are_destroyed_on_delete()
    // {

    // }

    // public function a_collection_of_classrooms_by_user_can_be_indexed()
    // {

    // }

    // public function a_classroom_has_a_name()
    // {

    // }

    // public function students_can_be_attached_to_classroom()
    // {

    // }

    // public function students_can_be_detached_from_classroom()
    // {

    // }

    // public function classroom_students_can_be_indexed()
    // {

    // }

    // public function playlists_can_be_attached_to_classroom()
    // {

    // }

    // public function playlists_can_be_detached_from_classroom()
    // {

    // }

    // public function classroom_playlists_can_be_indexed()
    // {

    // }



}
