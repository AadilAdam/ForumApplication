<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CreateThreadsTest extends TestCase
{
    /**
     * A test for authorized users.
     *
     */
    public function test_authenticated_user_create_threads()
    {
        // given a authenticated user
        //$this->actingAs(factory('App\User')->create());
        $this->signIn();

        //create a new thread
        $thread = make('App\Thread');
        //when we post it to the server, we  need to give it an array and not an object.
        //raw() returns an array., make() returns an object.
        $response = $this->post('/threads', $thread->toArray());

        //see the new thread.
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * test for unauthorized users.
     * 
     */
    public function test_guests_cannot_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');
        
        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /**
     * @test to check if thread required s a title.
     */
    public function testThreadRequiresTitle()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }
    /** 
     * @test 
     */
    function testThreadRequiresBody()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * @test for aunthorized users to not delete threads.
     * 
     */
    function testUnauthorizedUserMaynotDeleteThreads()
    {
        $this->withExceptionHandling();
        $thread = create('App\Thread');
        $response = $this->delete($thread->path());
        $response->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertRedirect('/login');

    }
    /**
     * @test for authorized users to delete threads
     */
    function testAuthorizedUserCanDeleteThreads()
    {
        $this->signIn();

        $thread = create('App\Thread', [
            'user_id' => auth()->id()
        ]);
        $reply = create('App\Reply', [
            'thread_id' => $thread->id
        ]);

        $this->json('DELETE', $thread->path());

        $this->assertDatabaseMissing('threads', [
            'id' => $thread->id
        ]);
        $this->assertDatabaseMissing('replies', [
            'id' => $reply->id
        ]);

    }

    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
