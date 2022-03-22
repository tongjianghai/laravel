<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;
use Illuminate\Database\Query\Builder;

class PostTopic extends Model
{
    use HasFactory;

    public function scopeInTopic(Builder $query, $topic_id)
    {
        return $query->where('topic_id', $topic_id);
    }
}
