<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;
use App\Models\AdminRole;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'password',
    ];

    /*
     * 一个用户有哪些角色
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_role_user', 'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    /*
     * 是否有某个角色
     */
    public function isInRoles($roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }

    /*
     * 是否有权限
     */
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }

    /*
     * 给用户分配角色
     */
    public function assignRole($roleName)
    {
        $role = AdminRole::where('name', $roleName)->first();
        return $this->roles()->save($role);
    }

    /*
     * 删除user和role的关联
     */
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }
}
