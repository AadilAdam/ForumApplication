<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{

    protected $thread;

    public function setup()
    {
        parent::setUp();

        //$this->thread = factory('App\Thread')->create();
        $this->thread = create('App\Thread');
    }

    /**
     * A test example. Browse all threads.
     *
     * @return void
     */
    public function test_user_browse_all_threads()
    {
        $this->signIn();
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    //setup tests in my database (test database), go to the phpunit.xml file and setup the test database.

    /**
    * user can view single thread.
    *
    */
    public function test_user_browse_single_thread()
    {
        $this->signIn();
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }
    
    
    /**
     * 
     */
    public function test_user_filter_threads_on_channels()
    {
        //$this->signIn();
        $channel= create('App\Channel');

        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotChannel = create('App\Thread');
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotChannel->title);
    }

    /** @test */
    function test_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
   }

   /**
    * @test
    */
   function test_user_filter_threads_by_those_notanswered()
   {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();
        $this->assertCount(1, $response);

   }

    /** @test */
    function test_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 1);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(1, $response['data']);
        $this->assertEquals(1, $response['total']);
     }
}
