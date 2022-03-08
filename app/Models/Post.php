<?php

namespace App\Models;

use \App\Models\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
