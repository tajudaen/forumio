<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Favoriteable;

class Reply extends Model
{
    use Favoriteable;

    protected $fillable = ['body', 'thread_id', 'user_id'];
    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
