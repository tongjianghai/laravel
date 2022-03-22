<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class AdminPermission extends Model
{
    use HasFactory;

    /*
     * 权限属于哪些角色
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_permission_role', 'permission_id', 'role_id')->withPivot(['permission_id', 'role_id']);
    }
}
