<?php
namespace Tests\Unit;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
use App\Reply;


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
        $reply = new Reply([
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    function test_wrap_mentioned_users_anchor_tags()
    {
        $reply = new Reply([
            'body' => 'Hello @Jane-Doe.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>.',
            $reply->body
        );
    }
    
}