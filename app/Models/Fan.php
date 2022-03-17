<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class Fan extends Model
{
    use HasFactory;

    public function fuser()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'fan_id');
    }

    public function suser()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'star_id');
    }
}
