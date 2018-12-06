<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadsTest extends TestCase
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

    function testUserSubscribeToThreads()
    {
        $this->signIn();

        //Given a thread 
        $thread = create('App\Thread');

        //user subscribes to the thread..
        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1, $thread->fresh()->subscriptions);

        // $this->assertCount(0, auth()->user()->notifications);

        // //Then, each time a new reply is left
        // $thread->addReply([
        //     'user_id' => auth()->id(),
        //     'body' => 'Some reply here.'
        // ]);

        // // A notification should be prepared to the user.

        // $this->assertCount(1, auth()->user()->fresh()->notifications);

    }

    function test_user_unsubscribe_from_threads()
    {
        $this->signIn();

        //Given a thread 
        $thread = create('App\Thread');

        $thread->subscribe();

        //user subscribes to the thread..
        $this->delete($thread->path() . '/subscriptions');

        // A notification should be prepared to the user.

        $this->assertCount(0, $thread->subscriptions);

    }

}