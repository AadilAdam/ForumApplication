<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
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


    public function test_mentioned_users_get_notified()
    {
        //Gven we have a user.
        $john = create('App\User', ['name' => 'johndoe']);
        $this->signIn($john);

        //and another user janedoe.
        $jane = create('App\User', ['name' => 'janedoe']);

        //if we have a thread

        $thread = create('App\Thread');
        //and on euser mentions other user on the thread.
        $reply = make('App\Reply', [
            'body' => '@janedoe look at us'
        ]);

        //then, jane doe should be notified.
        //adds a reply to a thread, post it on the page
        $this->json('post', $thread->path() . '/replies', $reply->toArray());
        $this->assertCount(1, $jane->notifications);

    }

    public function test_can_fetch_all_users_autocomplete()
    {
        create('App\User', ['name' => 'johndoe']);
        create('App\User', ['name' => 'johndoe2']);
        create('App\User', ['name' => 'janedoe']);
        
        $results = $this->json('GET', '/api/users', ['name' => 'john']);
        
        $this->assertCount(2, $results->json());
    }
}
