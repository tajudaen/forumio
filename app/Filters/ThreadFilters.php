<?php

namespace App\Filters;

use App\User;
use App\Channel;
use Illuminate\Http\Request;

class ThreadFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        if ($username = $this->request->by) {

            $user = User::where('name', $username)->firstOrFail();

            return $builder->where('user_id', $user->id);
        } elseif($channel = $this->request->channel) {
            return $builder->where('channel_id', $channel->id);
        }

        return $builder;
    }

}
