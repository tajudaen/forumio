<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;

class Favorite extends Model
{
    use RecordsActivity;

    protected $fillable = ['user_id', 'favorite_id', 'favorite_type'];

    public function favorite()
    {
        return $this->morphTo();
    }
}
