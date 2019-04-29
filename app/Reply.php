<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['body', 'thread_id', 'user_id'];
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
