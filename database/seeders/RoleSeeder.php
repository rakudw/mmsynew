<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatusEnum;
use App\Enums\CacheKeyEnum;
use App\Enums\RoleEnum;
use App\Helpers\CacheHelper;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;

class RoleSeeder extends BaseSeeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create super admin role
        $basicRole = Role::create([
            'name' => 'USER',
        ]);
        $basicRole->update([
            'id' => 0,
        ]);
        $rolesPendencies = $this->pendency();
        CacheHelper::purge(CacheKeyEnum::ALL_ENUMS);
        $this->walk(array_filter(array_map(function ($r) use ($rolesPendencies) {
            return $r->value > 0 ? [
                'id' => $r->value,
                'name' => $r->name,
                'metadata' => isset($rolesPendencies[$r->value]) ? (object)['pendency_application_status_ids' => array_map(function (ApplicationStatusEnum $applicationStatus) {
                    return $applicationStatus->id();
                }, $rolesPendencies[$r->value])] : null,
            ] : null;
        }, RoleEnum::cases())), [Role::class, 'create']);
        $superAdminRole = Role::find(RoleEnum::SUPER_ADMIN->value);

        // Create all the permisssions
        $this->walk($this->getPermissions(), [Permission::class, 'create']);

        $permissions = Permission::all();

        // Attach all the permissions to the super admin role
        $superAdminRole->permissions()->attach($permissions, ['created_by' => 0, 'created_at' => now()]);

        $user = User::find(1);

        // Attach role to the user
        $user->roles()->attach($superAdminRole, ['created_by' => 0, 'created_at' => now()]);
    }

    private function pendency(): array
    {
        return [
            RoleEnum::NODAL_DIC->value => [
                ApplicationStatusEnum::LOAN_REJECTED,
                ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER,
            ], RoleEnum::BANK_MANAGER->value => [
                ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS,
                ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT,
            ], RoleEnum::GM_DIC->value => [
                ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST,
            ], RoleEnum::NODAL_BANK->value => [
                ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE,
                ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE,
                ApplicationStatusEnum::PENDING_INTEREST_SUBSIDY_RELEASE,
            ], RoleEnum::EO_DIC->value => [
                ApplicationStatusEnum::SUBSIDY_60_RELEASED,
            ],
        ];
    }

    private function getPermissions()
    {
        return array_map(function ($permission) {
            return [
                'name' => $permission,
                'slug' => Str::slug($permission),
            ];
        }, ['Manage Users', 'Manage Banks', 'Manage Enums', 'Manage Activities', 'Manage Regions', 'Manage Post Offices','Manage Banners']);
    }
}
