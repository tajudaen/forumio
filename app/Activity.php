<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['type', 'user_id', 'subject_id', 'subject_type'];
    
    public function subject()
    {
        return $this->morphTo();
    }
}
