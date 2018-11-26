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
    public function test_user_cn_read_replies_of_single_thread()
    {
        $this->signIn();
        //each thraed will have many replies
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        //each thread should display on new page when clicked
        $response = $this->get($this->thread->path());

        //new page should show a thread and all its replies.
        $response->assertSee($reply->body);

    }

    /**
     * 
     */
    public function test_user_filter_threads_on_channels()
    {
        $this->signIn();
        $channel= create('App\Channel');

        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotChannel = create('App\Thread');
        $this->get('/threads' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($hreadInChannel->title);
    }

    /**
     * 
     */
    public function test_user_can_view_threads_by_username()
    {
        //
    }

    /**
     * 
     */
    function test_user_can_filter_threads_by_popularity()
    {
        //given the threads with replies count,
        // we can filter them by popularity
        $response = $this->getJson('threads?popular=1')->json();

        //then they should return from most replies to leats replies.
    }
}
