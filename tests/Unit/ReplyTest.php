<?php
namespace Tests\Unit;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;


class ReplyTest extends TestCase
{


    /** @test */
    function testReply_has_an_owner()
    {
        $reply = factory('App\Reply')->create();

        $this->assertInstanceOf('App\User', $reply->owner);
    }

    function test_reply_knows_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    function test_detect_all_mentioned_users_in_body()
    {
        $reply = create('App\Reply', [
            'body' => '@janedoe wants to talk to @johndoe'
        ]);

        $this->assertEquals(['janedoe', 'johndoe'], $reply->mentionedUsers());

    }
    
}