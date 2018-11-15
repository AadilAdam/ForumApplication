<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DatabaseMigrations;

class ThreadsTest extends TestCase
{

    protected $thread;

    public fucntion setup()
    {
        parent::setUp();


        $this->thread = factory('App\Thread')->create();
    }

    /**
     * A test example.
     *
     * @return void
     */
    public function user_browse_all_threads()
    {
        
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    //setup tests in my database (test database), go to the phpunit.xml file and setup the test database.

    /**
    * user can view single thread.
    *
    */
    public function user_browse_single_thread()
    {

        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    public function user_cn_read_replies_of_single_thread()
    {
        //each thraed will have many replies
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id])
        //each thread should display on new page when clicked
        $response = $this->get('/threads/' . $this->thread->id);

        //new page should show a thread and all its replies.
        $response->assertSee($reply->body);

    }
}
