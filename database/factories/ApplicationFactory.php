<?php

namespace Database\Factories;

use App\Enums\ActivityTypeEnum;
use App\Enums\ApplicationStatusEnum;
use App\Enums\ConstitutionTypeEnum;
use App\Enums\RegionTypeEnum;
use App\Enums\SocialCategoryEnum;
use App\Models\BankBranch;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $districtId = random_int(3, 14);
        $company = $this->faker->company();
        $enterprise = $this->getEnterpriseData($districtId, $company);
        $cost = $this->getCostData();
        return [
            'name' => $company,
            'form_id' => 1,
            'data' => (object)[
                "enterprise" => $enterprise,
                "email" => $this->faker->unique()->safeEmail(),
                "mobile" => random_int(7000000000, 9999999999),
                "owner" => $this->getOwnerData($enterprise),
                "cost" => $cost,
                "finance" => $this->getFinanceData($cost),
            ],
            'region_id' => $districtId,
            'status_id' => random_int(ApplicationStatusEnum::INCOMPLETE->id(), ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE->id()),
            'created_by' => 1,
            'created_at' => now()
        ];
    }

    private function getEnterpriseData(int $districtId, string $company):object {
        $tehsil = null;
        $block = null;
        $panchayat = null;
        while ($tehsil == null || $block == null || $panchayat == null) {
            $tehsil = Region::ofType(RegionTypeEnum::TEHSIL->id())->where('parent_id', $districtId)->inRandomOrder()->first();
            $block = Region::ofType(RegionTypeEnum::BLOCK_TOWN->id())->where('parent_id', $districtId)->inRandomOrder()->first();
            if ($block) {
                $panchayat = Region::ofType(RegionTypeEnum::PANCHAYAT_WARD->id())->where('parent_id', $block->id)->inRandomOrder()->first();
            }
        }
        $data = [
            "name" => $company,
            "activity_type_id" => random_int(ActivityTypeEnum::MANUFACTURING->id(), ActivityTypeEnum::TRADING->id()),
            "constitution_type_id" => random_int(ConstitutionTypeEnum::PARTNERSHIP->id(),ConstitutionTypeEnum::PRIVATE_LIMITED->id()),
            "employment" => random_int(1, 500),
            "area_type" => $this->faker->randomElement(['Rural', 'Urban']),
            "pincode" => random_int(170001, 179999),
            "district_id" => $districtId,
            "constituency_id" => Region::ofType(RegionTypeEnum::CONSTITUENCY->id())->where('parent_id', $districtId)->inRandomOrder()->first()->id,
            "tehsil_id" => $tehsil->id,
            "block_id" => $block->id,
            "panchayat_id" => $panchayat->id,
            "address" => $this->faker->streetAddress(),
        ];
        if ($data['activity_type_id'] == ActivityTypeEnum::MANUFACTURING->id()) {
            $data["products"] = $this->faker->jobTitle();
        } else {
            $data["activity_id"] = $data['activity_type_id'] == ActivityTypeEnum::TRADING->id() ? 77 : random_int(1, 76);
            $data['activity_details'] = $this->faker->jobTitle();
        }
        return (object)$data;
    }

    private function getOwnerData(object $enterprise):object {
        $gender = $this->faker->randomElement(['Male', 'Female', 'Other']);
        $data = [
            "name" => $this->faker->firstName($gender == 'Male' ? 'male' : ($gender == 'Female' ? 'female' : null)),
            "mobile" => random_int(6000000000, 9999999999),
            "email" => $this->faker->unique()->safeEmail(),
            "guardian_prefix" => $this->faker->randomElement(['S/O', 'W/O', 'D/O', 'C/O']),
            "guardian" => $this->faker->name(),
            "pincode" => random_int(170001, 179999),
            "district_id" => $enterprise->district_id,
            "is_specially_abled" => $this->faker->randomElement(['Yes', 'No']),
            "constituency_id" => $enterprise->constituency_id,
            "tehsil_id" => $enterprise->tehsil_id,
            "block_id" => $enterprise->block_id,
            "panchayat_id" => $enterprise->panchayat_id,
            "address" => $enterprise->address,
            "birth_date" => $this->faker->date('Y-m-d', '-20 years'),
            "aadhaar" => random_int(555555555555, 999999999999),
            "pan" => 'ABCDE' . random_int(1000, 9999) . 'F',
            "gender" => $gender,
            "social_category_id" => random_int(SocialCategoryEnum::GENERAL->id(), SocialCategoryEnum::OBC->id()),
        ];
        if($enterprise->constitution_type_id != ConstitutionTypeEnum::PROPRIETORSHIP->id()) {
            $partnersCount = random_int(1, 5);
            for($i = 0; $i < $partnersCount; $i++) {
                $data['partner_name'][] = $this->faker->name();
                $data['partner_gender'][] = $this->faker->randomElement(['Male', 'Female', 'Other']);
                $data['partner_social_category_id'] = random_int(SocialCategoryEnum::GENERAL->id(), SocialCategoryEnum::OBC->id());
                $data['partner_birth_date'][] = $this->faker->date('Y-m-d', '-18 years');
                $data['partner_aadhaar'][] = random_int(555555555555, 999999999999);
                $data['partner_mobile'][] = random_int(6000000000, 9999999999);
            }
        }
        return (object)$data;
    }

    public function getCostData():object {
        $total = 0;
        $data = [
            "is_land_required" => $this->faker->randomElement(['Yes', 'No']),
            "land_cost" => random_int(1, 1000000),
            "is_building_required" => $this->faker->randomElement(['Yes', 'No']),
            "furniture_fixtures_cost" => random_int(500000, 1000000),
            "machinery_cost" => random_int(500000, 1000000),
            "other_fixed_assets_cost" => random_int(20000, 100000),
            "working_capital" => random_int(100000, 300000),
        ];
        if($data['is_land_required'] == 'Yes') {
            $data['land_cost'] = random_int(1000000, 2000000);
            $total += $data['land_cost'];
        }
        if($data['is_building_required'] == 'Yes') {
            $data['building_status'] = $this->faker->randomElement(['Owned', 'Rented or Leased']);
            if($data['building_status'] == 'Owned') {
                $data['building_cost'] = random_int(100000, 500000);
                $total += $data['building_cost'];
            } else {
                $data['renovation'] = random_int(100000, 500000);
                $total += $data['renovation'];
            }
        }
        $data['project_cost'] = $total + $data['furniture_fixtures_cost'] + $data['machinery_cost'] + $data['other_fixed_assets_cost'] + $data['working_capital'];
        return (object)$data;
    }

    private function getFinanceData():object {
        $data = [
            "own_contribution" => random_int(10, 25),
            "bank_branch_id" => BankBranch::inRandomOrder()->first()->id,
        ];
        return (object)$data;
    }
}
