<?php

namespace App\Models;

/**
 * @property string $name
 * @property string $slug
 */
class Permission extends Base
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
