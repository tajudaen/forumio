<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->withoutExceptionHandling()->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function test_a_guest_cannot_favorite_any_reply()
    {
        $this->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_can_only_favorite_a_reply_one_time()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authenticated_user_can_unfavorite_any_reply()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);

        $this->delete('replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->fresh()->favorites);
        $this->assertDatabaseMissing('favorites', ['favorite_id' => $reply->id]);
    }
}
