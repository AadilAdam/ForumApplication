<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testUserHasProfile()
    {
        $user = create('App\User');

        $response = $this->get('/profiles/{$user->name }');

        $response->assertSee($user->name);
    }

    function testDisplayallThreadsbyUser()
    {
        $user = create('App\User');

        create('App\Thread', ['user_id', $user->id]);

        $response = $this->get('/profiles/{$user->name}');

        $response->assertSee($thread->title)
            ->assertSee($thread->body);


    }
}
