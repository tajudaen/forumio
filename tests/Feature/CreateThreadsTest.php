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
        $this->withoutExceptionHandling()->signIn();

        // When visiting to create a new thread
        $thread = make('App\Thread');

        // Submit the thread
        $response = $this->post('/threads', $thread->toArray());

        // Visit thread page
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->body)
            ->assertSee($thread->title);
    }

    public function test_guest_can_not_create_threads()
    {

        $this->get('/threads/create')->assertRedirect('/login');

        $this->post('/threads')->assertRedirect('/login');
    }
}
