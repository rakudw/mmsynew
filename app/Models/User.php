<?php

namespace App\Models;

use App\Enums\RegionTypeEnum;
use App\Enums\RoleEnum;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $mobile
 * @property string $mobile_verified_at
 * @property string $password
 * @property string $remember_token
 */
class User extends Authenticatable
{
    use HasApiTokens, HasRolesAndPermissions, Notifiable;

    private $cachedRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'mobile',
        'mobile_verified_at',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getRoles() {
        if (is_null($this->cachedRoles)) {
            $this->cachedRoles = $this->roles()->get();
        }
        return $this->cachedRoles;
    }

    /**
     * Fetch roles;
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')->withPivot('metadata')->withTimestamps();
    }

    /**
     * Check is user has specific role
     *
     * @return boolean
     *
     */
    public function hasRole(string $role): bool
    {
        return $this->getRoles()->where('name', $role)->count();
    }

    /**
     * if use is super admin
     *
     * @return boolean value
     *
     */
    public function isSuperAdmin(): bool
    {
        return $this->getRoles()->where('id', RoleEnum::SUPER_ADMIN->value)->count();
    }

    public function getPendencyApplicationStatusesAttribute():array
    {
        return collect(array_map(function ($r) {
            return $r['metadata'] ? $r['metadata']->pendency_application_status_ids : [];
        }, $this->roles()->select('roles.metadata')->get()->toArray()))->flatten()->toArray();
    }

    /**
     * if user is Nodal at DLC
     *
     * @return boolean value
     *
     */
    public function isNodalDIC(): bool
    {
        return $this->getRoles()->where('id', RoleEnum::NODAL_DIC->value)->count() > 0;
    }

    /**
     * if user is EO at DLC
     *
     * @return boolean value
     *
     */
    public function isEO(): bool
    {
        return $this->getRoles()->where('id', RoleEnum::EO_DIC->value)->count() > 0;
    }

    /**
     * if use is a Bank Manager
     *
     * @return boolean value
     *
     */
    public function isBankManager()
    {
        return $this->getRoles()->where('id', RoleEnum::BANK_MANAGER->value)
            ->count() > 0;
    }

    /**
     * if use is Nodal Bank
     *
     * @return boolean value
     *
     */
    public function isNodalBank()
    {
        return $this->getRoles()->where('id', RoleEnum::NODAL_BANK->value)
            ->count() > 0;
    }

    /**
     * if use is RO of Bank
     *
     * @return boolean value
     *
     */
    public function isBankRO()
    {
        return $this->getRoles()->where('id', RoleEnum::BANK_RO->value)
            ->count() > 0;
    }

    /**
     * if use is GM @ DLC
     *
     * @return boolean value
     *
     */
    public function isGm()
    {
        return $this->getRoles()->where('id', RoleEnum::GM_DIC->value)->count() > 0;
    }

    /**
     * if user is applicant
     *
     * @return boolean value
     *
     */
    public function isApplicant()
    {
        return $this->getRoles()->count() == 0;
    }

    public function getDistricts()
    {
        if ($this->isSuperAdmin() || $this->isBankRO() || $this->isBankManager()) {
            return Region::where('type_id', RegionTypeEnum::DISTRICT->id())
                        ->select('id')
                        ->get()
                        ->pluck('id')
                        ->toArray();
        }
        $records = DB::table('user_roles')->where('user_id', $this->id)->get();
        $districts = [];
        foreach ($records as $record) {
            if ($record->metadata) {
                $metadata = json_decode($record->metadata);
                $districts += isset($metadata->district_ids) ? $metadata->district_ids : [];
            }
        }
        return array_unique($districts);
    }

    public function canScheduleMeeting(): bool
    {
        return $this->isGm();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletor()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getBankBranchIdsAttribute(): array
    {
        if ($this->isSuperAdmin() || $this->isNodalBank()) {
            return BankBranch::select('id')->get()->pluck('id')->all();
        }
        if ($this->isGm() || $this->isNodalDIC() || $this->isEO()) {
            $districtIds = [];
            foreach ($this->getRoles() as $roleMap) {
                if ($roleMap->pivot->metadata) {
                    $metadata = json_decode($roleMap->pivot->metadata);
                    $districtIds += property_exists($metadata, 'district_ids') ? $metadata->district_ids : [];
                }
            }
            return BankBranch::whereIn('district_id', $districtIds)->select('id')->get()->pluck('id')->all();
        }
        $bankBranchIds = [];
        if ($this->isBankManager()) {
            foreach ($this->getRoles() as $roleMap) {
                if ($roleMap->pivot->metadata) {
                    $metadata = json_decode($roleMap->pivot->metadata);
                    $bankBranchIds += property_exists($metadata, 'bank_branch_ids') ? $metadata->bank_branch_ids : [];
                }
            }
        }
        if ($this->isBankRO()) {
            $bankIds = [];
            foreach ($this->getRoles() as $roleMap) {
                if ($roleMap->pivot->metadata) {
                    $metadata = json_decode($roleMap->pivot->metadata);
                    $bankIds += property_exists($metadata, 'bank_branch_ids') ? $metadata->bank_branch_ids : [];
                    $districtIds = property_exists($metadata, 'district_ids') ? $metadata->bank_branch_ids : [];
                    $bankBranchIds += BankBranch::whereIn('bank_id', $bankIds)
                        ->when(!empty($districtIds), fn($query) => $query->whereIn('district_id', $districtIds))
                        ->select('id')
                        ->get()
                        ->pluck('id')
                        ->all();
                }
            }
        }
        return array_unique($bankBranchIds);
    }

    public function getBankIdsAttribute():array
    {
        if ($this->isSuperAdmin() || $this->isNodalBank()) {
            return Bank::select('id')->get()->map(fn($b) => $b->id)->toArray();
        }
        $bankIds = [];
        foreach ($this->getRoles() as $record) {
            if ($record->pivot->metadata) {
                $metadata = json_decode($record->pivot->metadata);
                $bankIds += property_exists($metadata, 'bank_ids') ? $metadata->bank_ids : [];
                if (property_exists($metadata, 'bank_branch_ids')) {
                    $bankIds += BankBranch::find($metadata->bank_branch_ids)
                        ->map(fn($bb) => $bb->bank_id)
                        ->toArray();
                }
            }
        }
        return array_unique($bankIds);
    }

    /**
     * Help setup the mappings from the form data.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::creating(function (User $model)
        {
            $model->created_by = auth()->user() ? auth()->id() : 0;
            $model->created_at = now();
        });

        static::updating(function (User $model)
        {
            $model->updated_by = auth()->user() ? auth()->id() : 0;
            $model->updated_at = now();
        });

        static::deleting(function (User $model)
        {
            $model->deleted_by = auth()->user() ? auth()->id() : 0;
            $model->deleted_at = now();
        });
    }
}
