<?php

namespace Tests\Unit;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use DatabaseMigrations;

class ThreadTest extends TestCase
{

    public function setup()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    
    public function test_thread_has_replies()
    {

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }


    function test_thread_has_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
        
    }

    // function test_thread_can_addreply()
    // {

    //     $this->thread->addReply([
    //         'body' => 'Sample body',
    //         'user_id' => 1
    //     ]);

    //     $this->assertCount(1, $this->thread->replies);
    // }

    //test for a thread belongs to a channel.
    function test_thread_belongs_channel()
    {
        $this->thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    function test_thread_can_be_subscribed()
    {
        $thread = create('App\Thread');

        //authenticated user
        $this->signIn();

        //user subscribes to thread
        //This checks model behavior.
        $thread->subscribe($userId = 1);

        //we should fetch all threads that the user has subscribed to
        $this->assertCount(
            1, 
            $thread->subscriptions()->where('user_id', auth()->id())->count()
        );
    }

    public function test_thread_can_be_unsubscribed()
    {
        $thread = create('App\Thread');

        //user subscribes to thread
        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */
    function test_authenticated_user_is_subscribed()
    {
        $thread = create('App\Thread');
        
        $this->signIn();
        
        $this->assertFalse($thread->isSubscribedTo);
        
        $thread->subscribe();
        
        $this->assertTrue($thread->isSubscribedTo);
    }
}
