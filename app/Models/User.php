<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password'];


    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class, "user_id", "id");
    }

    public function fans()
    {
        return $this->hasMany(\App\Models\Fan::class, 'star_id', 'id');
    }

    public function stars()
    {
        return $this->hasMany(\App\Models\Fan::class, 'fan_id', 'id');
    }

    public function doFan($uid)
    {
        $fan = new \App\Models\Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }

    public function doUnfan($uid)
    {
        $fan = new \App\Models\Fan();
        $fan->star_id = $uid;
        return $this->stars()->delete($fan);
    }

    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id', $uid)->count();
    }

    public function hasStar($uid)
    {
        return $this->stars()->where('star_id', $uid)->count();
    }
}
