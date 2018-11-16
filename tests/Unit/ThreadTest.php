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

        $this>assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }


    function test_thread_has_creator()
    {
        $this>assertInstanceOf('App\User', $this->thread->creator);
        
    }

    function test_thread_can_addreply()
    {

        $this->thread->addReply([
            'body' => 'Sample body',
            'user_id' => 1
        ]);

        $this>assertCount(1, $this->replies);
    }

    //test for a thread belongs to a channel.
    function test_thread_belongs_channel()
    {
        $this->thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }
}
