<?php


namespace Tests\Feature;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ParticipateInThreadsTest extends TestCase
{

    public function test_unauthenticated_users_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        //$thread = factory('App\Thread')->create();

        // we need a reply, set up from
        //$reply = factory('App\Reply')->create();

        //$this->post('/threads/1/replies', []);
        $this->post($thread->path() . '/replies', []);
    }



    public function test_authenticated_user_participate_forum_threads()
    {
        //given authenticated user
        //$this->be($user = factory('App\User')->create());
        $this->signIn();

        //have existing thread
        $thread = create('App\Thread');

        // we need a reply, set up from
        $reply = make('App\Reply');

        //adds a reply to a thread, post it on the page
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

}