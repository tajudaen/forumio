<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();

        return back();
    }

    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();

        return back();
    }
}
