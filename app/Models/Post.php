<?php

namespace App\Models;

use \App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeAuthorBy(Builder $builder, $user_id)
    {
        return $builder->where('user_id', $user_id);
    }

    public function postTopics()
    {
        return $this->hasMany(\App\Models\PostTopic::class, 'post_id', 'id');
    }

    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
        return $query->doesntHave('postTopics', 'and', function ($q) use ($topic_id) {
            $q->where('topic_id', $topic_id);
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('available', function (Builder $builder) {
            $builder->whereIn('status', [0, 1]);
        });
    }
}
