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

}
