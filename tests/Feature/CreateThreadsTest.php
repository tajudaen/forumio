<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    public function test_a_logged_in_user_can_create_new_threads()
    {
        // A signed in user
        $this->actingAs(factory('App\User')->create());

        // When visiting to create a new thread
        $thread = factory('App\Thread')->create();

        // Submit the thread
        $this->post('/threads', $thread->toArray());

        // Visit thread page
        $this->get($thread->path())->assertSee($thread->title);
    }

    public function test_guest_can_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();

        $this->post('/threads', $thread->toArray());
    }
}
