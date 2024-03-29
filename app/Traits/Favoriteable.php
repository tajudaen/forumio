<?php

namespace App\Traits;

use App\Favorite;

trait Favoriteable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorite');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];
        $this->favorites()->where($attributes)->delete();
    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function myFavorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if ($this->favorites()->where($attributes)->exists()) {
            return true;
        }
        return false;
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
