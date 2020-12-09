<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	use RefreshDatabase;

    /**
     * test a user can be deactivated.
     *
     * @return void
     */
    public function test_user_can_be_deactivated()
    {
        //$this->withoutExceptionHandling();
        $user = factory(\App\User::class)->create();
        $this->assertEquals($user->isActive(),1);
        $user->deactivate();
        $this->assertEquals($user->isActive(),0);
    }

    /**
     * test a user can be activated.
     *
     * @return void
     */
    public function test_user_can_be_activated()
    {
    	$user = factory(\App\User::class)->create();
    	$user->deactivate();
    	$this->assertEquals($user->isActive(),0);
    	$user->activate();
    	$this->assertEquals($user->isActive(),1);

    }
}
