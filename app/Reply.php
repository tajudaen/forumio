<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Favoriteable;
use App\Traits\RecordsActivity;

class Reply extends Model
{
    use Favoriteable, RecordsActivity;

    protected $fillable = ['body', 'thread_id', 'user_id'];
    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . '#reply-' . $this->id;
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);
        return $matches[1];
    }
}
