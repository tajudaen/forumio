<?php

namespace App\Filters;

use App\User;
use App\Channel;
use Illuminate\Http\Request;

class ThreadFilters
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        if ($this->request->has('by')) {
            return $this->by($this->request->by);
        } elseif($channel = $this->request->channel) {
            return $builder->where('channel_id', $channel->id);
        }

        return $builder;
    }

    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}
