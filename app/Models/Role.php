<?php

namespace App\Models;

/**
 * @property string $name
 * @property string $slug
 * @property object $metadata
 * @property Permission[] $permissions
 */
class Role extends Base
{

    protected $casts = [
        'metadata' => 'object',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function getDistrictsAttribute()
    {
        if(is_string($this->pivot->metadata)) {
            $metadata = json_decode($this->pivot->metadata);
            if(property_exists($metadata, 'district_ids')) {
                return Region::whereIn('id', $metadata->district_ids)->get();
            }
        }
        return null;
    }

    public function getBankBranchesAttribute()
    {
        if(is_string($this->pivot->metadata)) {
            $metadata = json_decode($this->pivot->metadata);
            if(property_exists($metadata, 'bank_branch_ids')) {
                return BankBranch::whereIn('id', $metadata->bank_branch_ids)->get();
            }
        }
        return null;
    }

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'user_id', 'role_id');
    }
}
