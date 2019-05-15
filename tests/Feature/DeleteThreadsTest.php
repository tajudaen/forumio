<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_thread_can_be_deleted()
    {
        $this->withoutExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function test_a_guest_cannot_delete_threads()
    {
        $thread = create('App\Thread');

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(401);
    }

}
