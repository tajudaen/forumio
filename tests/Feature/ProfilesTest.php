<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_has_a_profile()
    {
        $user  = create('App\User');

        $this->withoutExceptionHandling()->get('/profiles/' . $user->name)
                ->assertSee($user->name);
    }

    public function test_profile_display_all_threads_by_the_user()
    {
        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->withoutExceptionHandling()->get('/profiles/' . $user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
