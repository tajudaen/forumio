<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    public function test_mentioned_users_in_a_reply_are_notified()
    {
        // Given we have a user Tom that is signed in.
        $tom = create('App\User', ['name' => 'Tom']);
        $this->signIn($tom);

        // Given we also have a user named Sarah.
        $sarah = create('App\User', ['name' => 'Sarah']);

        // If we have a thread
        $thread = create('App\Thread');

        // Then Tom replies to that thread and mentions @Sarah.
        $reply = make('App\Reply', [
            'body' => 'Hey @Sarah check this out'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        // Alternative
        // $thread->addReply([
        //     'body' => 'Hey @Sarah check this out',
        //     'user_id' => auth()->id()
        // ]);

        // Then @Sarah should receive a notification.
        $this->assertCount(1, $sarah->notifications);
    }
}
