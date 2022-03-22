<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->belongsToMany(\App\Models\Post::class, 'post_topics', 'topic_id', 'post_id');
    }
}
