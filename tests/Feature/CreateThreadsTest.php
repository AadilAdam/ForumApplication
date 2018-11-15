<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
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
        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread);

        //visit the thread page
        $this->get($thread-path());

        //see the new thread.
        $this->assertSee($thread->title)->assertsee($thread->body);
    }
}
