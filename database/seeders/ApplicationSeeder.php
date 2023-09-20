<?php

namespace Database\Seeders;

use App\Enums\RegionTypeEnum;
use App\Models\Form;
use App\Models\FormDesign;
use App\Models\Region;

class ApplicationSeeder extends BaseSeeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $hpState = Region::where('type_id', RegionTypeEnum::STATE->id())
                    ->where('name', 'Himachal Pradesh')
                    ->value('id');
        $this->walk([[
            'name' => 'Application for the Approval under Mukhya Mantri Swavlamban Yojana',
            'region_id' => $hpState,
        ], [
            'name' => 'Old Portal MMSY Application',
            'region_id' => $hpState,
        ], [
            'name' => 'Credit Guarantee Fund Trust for Micro and Small Enterprises (CGTMSE) Fee Reimbursement',
            'region_id' => $hpState,
            'parent_id' => 1,
        ], [
            'name' => 'Interest Subsidy Claim',
            'region_id' => $hpState,
            'parent_id' => 1,
        ]], [Form::class, 'create']);

        $this->walk([[
            'name' => 'Enterprise',
            'slug' => 'enterprise',
            'form_id' => 1,
            'design' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/enterprise.json')),
            'validations' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/enterprise_validation.json'), true),
            'order' => 0,
        ], [
            'name' => 'Ownership',
            'slug' => 'owner',
            'form_id' => 1,
            'design' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/owner.json')),
            'validations' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/owner_validation.json'), true),
            'order' => 1,
        ], [
            'name' => 'Project Cost',
            'slug' => 'cost',
            'form_id' => 1,
            'design' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/cost.json')),
            'validations' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/cost_validation.json'), true),
            'order' => 2,
        ], [
            'name' => 'Means of Finance',
            'slug' => 'finance',
            'form_id' => 1,
            'design' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/finance.json')),
            'validations' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/finance_validation.json'), true),
            'order' => 3,
        ], [
            'name' => 'Claim Form',
            'slug' => 'form',
            'form_id' => 3,
            'design' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/cgtmse.json')),
            'validations' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/cgtmse_validation.json'), true),
            'order' => 0,
        ], [
            'name' => 'Claim Form',
            'slug' => 'form',
            'form_id' => 4,
            'design' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/interest.json')),
            'validations' => json_decode(file_get_contents(__DIR__ . '/../json/form-design/interest_validation.json'), true),
            'order' => 0,
        ]], [FormDesign::class, 'create']);

        // Applicat ion::facto ry()->times(500)->create();
    }
}