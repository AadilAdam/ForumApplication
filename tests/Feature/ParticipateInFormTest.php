<?php


namespace Tests\Feature;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ParticipateInThreadsTest extends TestCase
{

    function test_unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);
    }



    function test_authenticated_user_participate_forum_threads()
    {
        //given authenticated user
        $this->be($user = factory('App\User')->create());

        //have existing thread
        $thread = factory('App\Thread')->create();

        // we need a reply, set up from
        $reply = factory('App\Reply')->make();

        //adds a reply to a thread, post it on the page
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }


}