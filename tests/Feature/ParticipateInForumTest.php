<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    public function test_an_authenticated_user_can_participate_in_forum_thread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post('/threads/' . 'channel' . '/' . $thread->id . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

    public function test_unauthenticated_user_cannot_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/channel/1/replies', [])
            ->assertRedirect('/login');
    }
}
