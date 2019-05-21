<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_can_subscribe_to_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->get($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    public function test_a_user_can_unsubscribe_to_threads()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->get($thread->path() . '/subscriptions');
        $this->get($thread->path() . '/endsubscriptions');
        $this->assertCount(0, $thread->fresh()->subscriptions);
    }
}
