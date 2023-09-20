<?php

namespace App\Traits;

use App\Enums\CacheKeyEnum;
use App\Helpers\CacheHelper;
use App\Models\Permission;
use App\Models\Role;
use App\Enums\RoleEnum;

// larashout.com/laravel-roles-and-permissions

trait HasRolesAndPermissions
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    /**
     * @param array $roles Can be int[] or RoleEnum[].
     * @return bool
     */
    public function hasRole(...$roles): bool
    {
        $rolesCollection = collect(CacheHelper::cached(CacheKeyEnum::ALL_ROLES));
        foreach ($roles as $role) {
            if (is_a($role, RoleEnum::class)) {
                $role = $role->value;
            }
            if ($rolesCollection->contains('id', $role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        return $this->hasPermissionTo($permission) || $this->hasPermissionThroughRole($permission);
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $permissions
     * @return mixed
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function deletePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return HasRolesAndPermissions
     */
    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }
}
