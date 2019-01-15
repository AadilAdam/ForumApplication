<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
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

    public function testRecordActivityWhenThreadCreated()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread' 
        ]);

        $activity = Activity::first();
        //dd($thread);
        //dd($activity);
        $this->assertEquals($activity->subject->id, $thread->id);

    }

    /**
     * 
     */
    public function testRecordActivityReplyCreated()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }

    /**
     * 
     */
    public function testFetchesFeedforAnyUser()
    {
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->id()]);

        //and another thread from a week ago
        create('App\Thread', [
            'user_id' =>auth()->id(), 
            'created_at' => Carbon::now()->subWeek()
        ]);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        //when we fecth the feed.
        $feed = Activity::feed(auth()->user());

        //then it should be returned in proper format.
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));

    }
}
