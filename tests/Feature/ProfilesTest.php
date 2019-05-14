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
}
