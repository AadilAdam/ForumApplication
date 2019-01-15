<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Notifications\DatabaseNotification;

class NotificationsTest extends TestCase
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

    public function setup()
    {
        parent::setUp();

        $this->signIn();
    }

    public function test_notification_prepared_when_thread_receives_reply()
    {
        //Given a thread 
        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        //Then, each time a new reply is left
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here.'
        ]);

        // A notification should be prepared to the user.
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        //Then, each time a new reply is left
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply here.'
        ]);

        // A notification should be prepared to the user.
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    function test_user_fetch_unread_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(1, $this->getJson('/profiles/'. auth()->user()->name . '/notifications')->json());
    }

    public function test_user_can_mark_notification_as_read()
    {

        create(DatabaseNotification::class);

        $user = auth()->user();
        //This will return all notifications that would return the records that have the column "read_at" as null.
        $this->assertCount(1, $user->unreadNotifications);

        // if we are deleting a notifications, we are making a delete request to some endpoint.
        $this->delete('/profiles/{ $user->name }/notifications/' . $user->unreadNotifications->first()->id);

        //$this->assertCount(0, $user->fresh()->unreadNotifications);

    }
}
