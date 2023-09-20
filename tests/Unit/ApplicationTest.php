<?php

namespace Tests\Unit;

use App\Enums\ApplicationStatusEnum;
use App\Enums\ConstitutionTypeEnum;
use App\Enums\SocialCategoryEnum;
use App\Models\Application;
use App\Models\Bank;
use App\Models\Region;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class ApplicationTest extends TestCase
{
    use CreatesApplication;

    public function test_that_application_is_a_firm()
    {
        foreach([ConstitutionTypeEnum::PARTNERSHIP, ConstitutionTypeEnum::LIMITED_LIABILITY_PARTNERSHIP, ConstitutionTypeEnum::PRIVATE_LIMITED] as $constitution) {
            $application = new Application();
            $application->data = (object)[
                'enterprise' => (object)[
                    'constitution_type_id' => $constitution->id()
                ]
            ];
            $this->assertTrue($application->isAFirm(), "{$constitution->value} is not recognized as a firm!");
        }
    }

    public function test_that_application_is_not_a_firm()
    {
        foreach([ConstitutionTypeEnum::PROPRIETORSHIP] as $constitution) {
            $application = new Application();
            $application->data = (object)[
                'enterprise' => (object)[
                    'constitution_type_id' => $constitution->id()
                ]
            ];
            $this->assertFalse($application->isAFirm(), "{$constitution->value} is recognized as a firm!");
        }
    }

    public function test_that_application_is_filed_by_an_sc_or_st()
    {
        foreach([SocialCategoryEnum::SC, SocialCategoryEnum::ST] as $socialCategory) {
            $application = new Application();
            $application->data = (object)[
                'enterprise' => (object)[
                    'constitution_type_id' =>ConstitutionTypeEnum::PRIVATE_LIMITED->id(),
                ], 'owner' => (object)[
                    'social_category_id' => $socialCategory->id(),
                    'partner_social_category_id' => [SocialCategoryEnum::SC->id()],
                ]
            ];
            $this->assertTrue($application->isSCOrST(), "{$socialCategory->value} is not recognized as a SC/ST!");
        }
    }

    public function test_that_application_is_filed_by_a_woman()
    {
        $application = new Application();
        $application->data = (object)[
            'enterprise' => (object)[
                'constitution_type_id' =>ConstitutionTypeEnum::PRIVATE_LIMITED->id(),
            ], 'owner' => (object)[
                'gender' => 'Female',
                'partner_gender' => ['Female'],
            ]
        ];
        $this->assertTrue($application->isWomanEnterprise());
    }

    public function test_that_application_is_filed_by_a_specially_abled_person()
    {
        $application = new Application();
        $application->data = (object)[
            'enterprise' => (object)[
                'constitution_type_id' =>ConstitutionTypeEnum::PRIVATE_LIMITED->id(),
            ], 'owner' => (object)[
                'is_specially_abled' => true,
            ]
        ];
        $this->assertEquals($application->subsidy_percentage, 35);
    }

    public function test_that_region_cache_works()
    {
        $region = Region::inRandomOrder()->first();
        $cachedRegion = Region::throughCache($region->id);
        $this->assertEquals($cachedRegion->name, $region->name);
    }

    public function test_that_bank_cache_works()
    {
        $bank = Bank::inRandomOrder()->first();
        $cachedBank = Bank::throughCache($bank->id);
        $this->assertEquals($cachedBank->name, $bank->name);
    }

    public function test_that_application_with_duplicate_aadhaar_will_not_be_submitted()
    {
        $dbApplication = Application::orderByDesc('id')->whereNotIn('status_id', [
            ApplicationStatusEnum::WITHDRAWN->id(),
            ApplicationStatusEnum::INCOMPLETE->id(),
            ApplicationStatusEnum::LOAN_REJECTED->id(),
            ApplicationStatusEnum::REJECTED_AT_DISTRICT_INDUSTRIES_CENTER->id(),
            ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id()
        ])->first();

        dd($dbApplication->getData('owner', 'aadhaar'));
    }
}
