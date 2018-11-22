<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CreateThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_authenticated_user_create_threads()
    {
        // given a authenticated user
        $this->actingAs(factory('App\User')->create());
        //create a new thread

        //when we post it to the server, we  need to give it an array and not an object.
        //raw() returns an array., make() returns an object.
        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());

        //visit the thread page
        $response = $this->get($thread->path());

        //see the new thread.
        $response->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * test for unauthorized users.
     * 
     */
    function test_guest_can_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());

    }
}
