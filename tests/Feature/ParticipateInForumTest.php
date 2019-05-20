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

    public function test_a_reply_requires_a_body()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())->assertSessionHasErrors('body');
    }

    public function test_unauthorized_users_cannot_delete_replies()
    {
        $reply = create('App\Reply');

        $this->delete('/replies/' . $reply->id)->assertRedirect('/login');

        $this->signIn()->delete('/replies/' . $reply->id)->assertStatus(403);
    }

    public function test_authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete('/replies/' . $reply->id)->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
