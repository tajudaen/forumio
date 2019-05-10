<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /**
     * A user can browse threads.
     *
     * @return void
     */
    public function test_a_user_can_browse_threads()
    {

        $response = $this->get('threads');
        $response->assertSee($this->thread->title);
        $response->assertStatus(200);
    }

    public function test_user_can_read_a_single_thread()
    {
        $response = $this->get('/threads/' . $this->thread->channel . '/' . $this->thread->id);
        $response->assertSee($this->thread->title);
        $response->assertStatus(200);
    }

    public function test_a_user_can_see_replies_that_are_associated_with_a_thread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $response = $this->get('/threads/' . $this->thread->channel->slug . '/' . $this->thread->id);
        $response->assertSee($reply->body);
        $response->assertStatus(200);
    }

    public function test_a_user_can_filter_threads_according_to_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->withoutExceptionHandling()->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function test_a_user_can_filter_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');
        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    public function test_a_user_can_filter_threads_by_number_of_replies()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithZeroReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
