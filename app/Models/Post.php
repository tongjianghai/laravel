<?php

namespace App\Models;

use \App\Models\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;

    public function searchableAs()
    {
        return "posts_index";
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->orderBy('created_at', 'desc');
    }

    public function zan($user_id)
    {
        return $this->hasOne(\App\Models\Zan::class)->where('user_id', $user_id);
    }

    public function zans()
    {
        return $this->hasMany(\App\Models\Zan::class);
    }
}
