<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class AdminRole extends Model
{
    use HasFactory;

    protected $table = "admin_roles";

    /*
     * 当前角色的所有权限
     */
    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, 'admin_permission_role', 'role_id', 'permission_id')->withPivot(['role_id', 'permission_id']);
    }

    /*
     * 给角色授权
     */
    public function grantPermission($permission)
    {
        return $this->permissions()->save($permission);
    }

    /*
     * 删除role和permission的关联
     */
    public function deletePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    /*
     * 角色是否有权限
     */
    public function hasPermission($permission)
    {
        return $this->permissions->contains($permission);
    }
}
