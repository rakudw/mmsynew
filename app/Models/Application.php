<?php

namespace App\Models;

use App\Enums\ActivityTypeEnum;
use App\Enums\ApplicationStatusEnum;
use App\Enums\CacheKeyEnum;
use App\Enums\ConstitutionTypeEnum;
use App\Enums\MeetingApplicationStatusEnum;
use App\Enums\RoleEnum;
use App\Enums\SocialCategoryEnum;
use App\Helpers\CacheHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @property string $name
 * @property int $form_id
 * @property object $data
 * @property int $region_id
 * @property int $status_id
 * @property int $parent_id
 * @property string $address
 * @property string $submitted_at
 * @property string $unique_id
 * @property string $mobile
 * @property Date $status_updated_at
 * @property ActivityTypeEnum $activity_type
 * @property Activity|string $activity
 * @property int $subsidy_percentage
 * @property int $project_cost
 * @property int $capital_expenditure
 * @property int $subsidy_eligible_amount
 * @property int $subsidy_amount
 * @property int[] $bank_branch_manager_ids
 * @property Meeting $approval_meeting
 * @property ApplicationStatusEnum $application_status
 * @property Form $form
 * @property Region $region
 * @property Enum $status
 * @property Application $parent
 */
class Application extends Base implements Auditable
{
    use HasFactory, AuditableTrait, HasJsonRelationships;

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['data', 'status_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'form_id',
        'data',
        'region_id',
        'status_id',
    ];

    protected $casts = [
        'data' => 'object',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applicationDocuments()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'application_documents');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function getProjectCostAttribute()
    {
        return $this->capital_expenditure + intval($this->getData('cost', 'working_capital', null, 0));
    }

    public function getFinanceWorkingCapitalAttribute()
    {
        $workingCapital = $this->getData('cost', 'working_capital', null, 0);
        return $workingCapital - ($workingCapital * ($this->getData('finance', 'own_contribution', null, 10) / 100));
    }

    public function getCapitalExpenditureAttribute()
    {
        $capitalExpenditure = intval($this->getData('cost', 'land_cost', null, 0));
        $capitalExpenditure += intval($this->getData('cost', 'building_cost', null, 0));
        $capitalExpenditure += intval($this->getData('cost', 'assets_cost', null, 0));
        $capitalExpenditure += intval($this->getData('cost', 'machinery_cost', null, 0));

        return $capitalExpenditure;
    }

    public function getOwnContributionAmountAttribute()
    {
        return round($this->project_cost * ($this->getData('finance', 'own_contribution', null, 10) / 100));
    }

    public function getTermLoanAttribute()
    {
        return $this->project_cost - $this->own_contribution_amount - $this->finance_working_capital;
    }

    public function getSubsidyEligibleAmountAttribute()
    {
        return min(($this->capital_expenditure - intval($this->getData('cost', 'land_cost', null, 0))), 6000000);
    }

    public function getSubsidyAmountAttribute()
    {
        $amount = $this->getData('subsidy', 'amount');
        return is_null($amount) ? round($this->subsidy_eligible_amount * ($this->subsidy_percentage / 100)) : $amount;
    }

    public function subsidyAmount(int $percent = 60)
    {
        return round($this->subsidy_amount * ($percent / 100));
    }

    public function getUniqueIdAttribute()
    {
        $region = $this->region;
        return 'MMSY-' . strtoupper(substr($region ? $region->name : 'NA', 0, 2)) . '-' . $this->id;
    }

    public function getSubmittedAtAttribute(): string
    {
        $timeline = $this->timelines()->where('new_status_id', ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER->id())->orderBydesc('created_at')->first();
        return date('Y-m-d', strtotime($timeline ? $timeline->created_at : $this->created_at));
    }

    public function getRegionAttribute(): ?Region
    {
        return Region::throughCache($this->region_id);
    }

    public function getOwnerShortAddressAttribute()
    {
        $panchayat = Region::throughCache($this->getData('owner', 'panchayat_id'));
        $block = Region::throughCache($this->getData('owner', 'block_id'));
        $tehsil = Region::throughCache($this->getData('owner', 'tehsil_id'));

        $guardianPrefix = $this->getData('owner', 'guardian_prefix');
        $guardianPrefix = (!$guardianPrefix || $guardianPrefix == 'NA') ? ($this->getData('owner', 'gender') == 'Female' ? 'D/O' : 'S/O') : $guardianPrefix;

        return implode(', ', array_filter([$guardianPrefix . ' ' . $this->getData('owner', 'guardian'), $this->getData('owner', 'address'), $panchayat?->name, 'Block ' . $block?->name, 'Tehsil ' . $tehsil?->name])) . ' - ' . $this->getData('owner', 'pincode');
    }

    public function getOwnerAddressAttribute()
    {
        $panchayat = Region::throughCache($this->getData('owner', 'panchayat_id'));
        $block = Region::throughCache($this->getData('owner', 'block_id'));
        $tehsil = Region::throughCache($this->getData('owner', 'tehsil_id'));

        $guardianPrefix = $this->getData('owner', 'guardian_prefix');
        $guardianPrefix = (!$guardianPrefix || $guardianPrefix == 'NA') ? ($this->getData('owner', 'gender') == 'Female' ? 'D/O' : 'S/O') : $guardianPrefix;

        return implode(', ', array_filter([
            $this->getData('owner', 'name') . ' ' . $guardianPrefix . ' ' . $this->getData('owner', 'guardian'),
            $this->getData('owner', 'address'),
            $panchayat ? $panchayat->name : 'Unknown Panchayat', // Check if $panchayat is null
            $block ? 'Block ' . $block->name : 'Unknown Block', // Check if $block is null
            $tehsil ? 'Tehsil ' . $tehsil->name : 'Unknown Tehsil', // Check if $tehsil is null
        ]));
    }

    public function bankBranch()
    {
        return $this->belongsTo(BankBranch::class, 'data->finance->bank_branch_id');
    }

    public function getBankBranchManagerIdsAttribute(): array
    {
        $bankBranchId = $this->getData('finance', 'bank_branch_id');
        if ($bankBranchId) {
            return DB::table('user_roles')
                ->where('role_id', RoleEnum::BANK_MANAGER->value)
                ->whereJsonContains('metadata->bank_branch_ids', $bankBranchId)
                ->select(['user_id'])
                ->get()->map(fn($ur) => $ur->user_id)
                ->toArray();
        }
        return [];
    }

    public function getGmIdAttribute(): int
    {
        return DB::table('user_roles')
            ->where('role_id', RoleEnum::GM_DIC->value)
            ->whereJsonContains('metadata->district_ids', $this->region_id)
            ->select(['user_id'])
            ->first()->user_id;
    }

    public function getNodalBankUserIdsAttribute(): array
    {
        return DB::table('user_roles')
            ->where('role_id', RoleEnum::NODAL_BANK->value)
            ->select(['user_id'])
            ->get()->map(fn($ur) => $ur->user_id)
            ->toArray();
    }

    public function getBankBranchDetailsAttribute(): string
    {
        if (!$this->relationLoaded('bankBranch')) {
            $this->load('bankBranch')->with('bank');
        }
        $branch = $this->bankBranch;
        return $branch ? "{$branch->bank->name}, {$branch->name} ({$branch->ifsc}" . ($branch->prefix ? " - {$branch->prefix})" : ')') : 'NA';
    }

    public function getShortAddressAttribute()
    {
        $panchayat = Region::throughCache($this->getData('enterprise', 'panchayat_id'));
        $block = Region::throughCache($this->getData('enterprise', 'block_id'));
        $tehsil = Region::throughCache($this->getData('enterprise', 'tehsil_id'));

        return implode(', ', array_filter([$this->getData('enterprise', 'address'), $panchayat ? $panchayat->name : null, $block ? ('Block ' . $block->name) : null, $tehsil ? 'Tehsil ' . $tehsil->name : null])) . ' - ' . $this->getData('enterprise', 'pincode');
    }

    public function getAddressAttribute()
    {
        $panchayat = Region::throughCache($this->getData('enterprise', 'panchayat_id'));
        $block = Region::throughCache($this->getData('enterprise', 'block_id'));
        $tehsil = Region::throughCache($this->getData('enterprise', 'tehsil_id'));

        return implode(', ', array_filter([$this->getData('enterprise', 'address'), $panchayat ? $panchayat->name : null, $block ? ('Block ' . $block->name) : null, $tehsil ? 'Tehsil ' . $tehsil->name : null, 'Distt. ' . Region::throughCache($this->getData('enterprise', 'district_id'))->name])) . ' - ' . $this->getData('enterprise', 'pincode');
    }
    public function getOwnerBlock()
    {
        $block = Region::throughCache($this->getData('enterprise', 'block_id'));
        return $block ? $block->name : '';
    }

    public function getMobileAttribute()
    {
        return $this->getData('owner', 'mobile');
    }

    public function getApprovalMeetingAttribute()
    {
        return $this->meetings()->where('status', MeetingApplicationStatusEnum::APPROVED)->first();
    }

    public function isAFirm(): bool
    {
        return ConstitutionTypeEnum::fromId($this->getData('enterprise', 'constitution_type_id')) != ConstitutionTypeEnum::PROPRIETORSHIP;
    }

    public function isWomanEnterprise(): bool
    {
        $gender = $this->getData('owner', 'gender');
        if (!$gender) {
            return false;
        }
        $isWoman = $gender == 'Female';
        if ($isWoman && $this->isAFirm()) {
            $partnerGenders = $this->getData('owner', 'partner_gender');
            if ($partnerGenders) {
                $uniques = array_unique($partnerGenders);
                return (count($uniques) == 1) && ($uniques[0] == 'Female');
            }
        }
        return $isWoman;
    }

    public function isSpeciallyAbledEnterprise(): bool
    {
        $isSpeciallyAbled = $this->getData('owner', 'is_specially_abled');
        if (!$isSpeciallyAbled) {
            return false;
        }
        if ($isSpeciallyAbled && $this->isAFirm()) {
            $partnersSpeciallyAbled = $this->getData('owner', 'partner_is_specially_abled');
            if ($partnersSpeciallyAbled[0] == 'Yes') {
                $uniques = array_unique($partnersSpeciallyAbled);
                return (count($uniques) == 1) && $uniques[0];
            }
        }
        return $isSpeciallyAbled;
    }

    public function isSCOrST(): bool
    {
        $socialCategoryId = $this->getData('owner', 'social_category_id');
        if (!$socialCategoryId) {
            return false;
        }
        $scStSocialCategoryIds = [SocialCategoryEnum::SC->id(), SocialCategoryEnum::ST->id()];
        $isSCOrST = in_array($socialCategoryId, $scStSocialCategoryIds);
        if ($isSCOrST && $this->isAFirm()) {
            $partnerSocialCategories = $this->getData('owner', 'partner_social_category_id');
            if ($partnerSocialCategories) {
                foreach ($partnerSocialCategories as $partnerSocialCategory) {
                    $isSCOrST = in_array($partnerSocialCategory, $scStSocialCategoryIds);
                    if (!$isSCOrST) {
                        break;
                    }
                }
            }
        }
        return $isSCOrST;
    }

    private function getOwnerSubsidyEligibility(): int
    {
        if (($this->getData('owner', 'is_specially_abled') == 'Yes') || ($this->getData('owner', 'gender') == 'Female')) {
            return 35;
        }
        if (in_array($this->getData('owner', 'social_category_id'), [SocialCategoryEnum::SC->id(), SocialCategoryEnum::ST->id()])) {
            return 30;
        }
        return 25;
    }

    private function getPartnersSubsidyEligibility(): array
    {

        if (!$this->isAFirm()) {
            return [];
        }
        $partnerGenders = $this->getData('owner', 'partner_gender', null, []);
        $partnerIsSpeciallyAbledValues = $this->getData('owner', 'partner_is_specially_abled');
        $partnerSocialCategories = $this->getData('owner', 'partner_social_category_id');

        $result = [];
        foreach ($partnerGenders as $i => $gender) {
            if (($partnerIsSpeciallyAbledValues[$i] == 'Yes') || ($gender == 'Female')) {
                $result[] = 35;
            } elseif (in_array($partnerSocialCategories[$i], [SocialCategoryEnum::SC->id(), SocialCategoryEnum::ST->id()])) {
                $result[] = 30;
            } else {
                $result[] = 25;
            }
        }
        return $result;
    }

    public function getSubsidyPercentageAttribute()
    {
        $percentage = $this->getData('subsidy', 'percentage');
        if (is_null($percentage)) {
            $ownerSubsidyPercentage = $this->getOwnerSubsidyEligibility();
            if ($ownerSubsidyPercentage > 25) {
                $partnersSubsidyPercentages = $this->getPartnersSubsidyEligibility();
                return empty($partnersSubsidyPercentages) ? $ownerSubsidyPercentage : min($partnersSubsidyPercentages);
            }
            return $ownerSubsidyPercentage;
        } else {
            return $percentage;
        }
    }

    public function getCategories(): array
    {
        $result = [];
        $result['SPECIALLY ABLED'] = ['total' => 1, 'eligible' => 0];
        $result['WOMAN ENTERPRISE'] = ['total' => 1, 'eligible' => 0];
        $result['SC/ST'] = ['total' => 1, 'eligible' => 0];
        if ($this->getData('owner', 'is_specially_abled') == 'Yes') {
            $result['SPECIALLY ABLED']['eligible']++;
        }
        if ($this->getData('owner', 'gender') == 'Female') {
            $result['WOMAN ENTERPRISE']['eligible']++;
        }
        if (in_array($this->getData('owner', 'social_category_id'), [SocialCategoryEnum::SC->id(), SocialCategoryEnum::ST->id()])) {
            $result['SC/ST']['eligible']++;
        }

        $partnerGenders = $this->getData('owner', 'partner_gender', null, []);
        $partnerIsSpeciallyAbledValues = $this->getData('owner', 'partner_is_specially_abled');
        $partnerSocialCategories = $this->getData('owner', 'partner_social_category_id');

        foreach ($partnerGenders as $i => $gender) {
            $result['SPECIALLY ABLED']['total']++;
            $result['WOMAN ENTERPRISE']['total']++;
            $result['SC/ST']['total']++;
            if ($partnerIsSpeciallyAbledValues[$i] == 'Yes') {
                $result['SPECIALLY ABLED']['eligible']++;
            }
            if ($gender == 'Female') {
                $result['WOMAN ENTERPRISE']['eligible']++;
            }
            if (in_array($partnerSocialCategories[$i], [SocialCategoryEnum::SC->id(), SocialCategoryEnum::ST->id()])) {
                $result['SC/ST']['eligible']++;
            }
        }
        return $result;
    }

    public function getSocialCategoryAttribute()
    {
        return $this->getData('owner', 'social_category_id') > 0 ? SocialCategoryEnum::fromId($this->getData('owner', 'social_category_id')) : SocialCategoryEnum::GENERAL;
    }

    public function getStatusUpdatedAtAttribute()
    {
        /* $statusTimeline = $this->timelines()->where('new_status_id', $this->status_id)->orderBy('created_at', 'DESC')->first();
        if ($statusTimeline) {
        return $statusTimeline->created_at;
        } */
        return $this->updated_at ? $this->updated_at : $this->created_at;
    }

    public function getActivityTypeAttribute(): ActivityTypeEnum
    {
        return ActivityTypeEnum::fromId($this->getData('enterprise', 'activity_type_id'));
    }

    public function getConstitutionTypeAttribute(): ConstitutionTypeEnum
    {
        return ConstitutionTypeEnum::fromId($this->getData('enterprise', 'constitution_type_id'));
    }



    public function getActivityAttribute(): string
{
    try {
        $activities = CacheHelper::cached(CacheKeyEnum::ALL_ACTIVITIES);
        
        if (!$activities) {
            throw new ModelNotFoundException('Activities cache is empty');
        }
        
        $activity = collect($activities)
            ->where('id', $this->getData('enterprise', 'activity_id'))
            ->first();
        
        if (!$activity) {
            throw new ModelNotFoundException('Activity not found');
        }

        if ($this->getData('enterprise', 'activity_type_id') == ActivityTypeEnum::MANUFACTURING->id()) {
            return $activity['name'] . ', ' . $this->getData('enterprise', 'products');
        } else {
            return $activity['name'] . ', ' . $this->getData('enterprise', 'activity_details');
        }
    } catch (ModelNotFoundException $exception) {
        // Handle the exception here, e.g., log it, return a default value, or throw a custom exception
        return 'Activity not found';
    }
}

    

    public function getApplicantAgeAttribute(): int
    {
        $dateOfBirth = $this->getData('owner', 'birth_date');
        if ($dateOfBirth) {
            return $this->calculateAge($dateOfBirth);
        }
        return 'NA';
    }

    public function calculateAge($date): int
    {
        return \DateTime::createFromFormat('Y-m-d', $date)
            ->diff(\DateTime::createFromFormat('Y-m-d', $this->submitted_at))
            ->y;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function formDesigns()
    {
        return FormDesign::where('form_id', $this->form_id)->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Enum::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Application::class, 'parent_id');
    }

    /**
     * Get data corresponding to the form design slug.
     *
     * @param string $formDesignSlug
     * @return mixed
     */
    public function getData(string $formDesignSlug, string $key, mixed $default = null, mixed $defaultValue = null)
    {
        $applicationData = is_string($this->data) ? json_decode($this->data) : $this->data;
        if (is_string($default)) {
            $keys = explode('.', $default);
            if ($keys[0] == 'user') {
                array_shift($keys);
                $default = (object) $this->user()->toArray();
            } else {
                $default = $applicationData;
            }
            foreach ($keys as $prop) {
                if (property_exists($default, $prop)) {
                    $default = $default->$prop;
                } else {
                    $default = $defaultValue;
                    break;
                }
            }
        }
        return isset($applicationData->$formDesignSlug) && isset($applicationData->$formDesignSlug->$key) ? $applicationData->$formDesignSlug->$key : $default ?? $defaultValue;
    }

    /**
     * Help setup the mappings from the form data.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::deleting(function (Application $application) {
            $application->deleted_by = auth()->user() ? auth()->id() : 0;
            $application->deleted_at = now();
        });

        static::creating(function (Application $application) {
            Application::setMappings($application);
            $application->created_by = auth()->user() ? auth()->id() : 0;
            $application->created_at = now();
        });

        static::updating(function (Application $application) {
            Application::setMappings($application);
            $application->updated_by = auth()->user() ? auth()->id() : 0;
            $application->updated_at = now();
        });
    }

    public function getBankRemarksAttribute(): string
    {
        $timeline = $this->timelines()->where('old_status_id', ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id())->where('new_status_id', ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id())->first();
        return $timeline ? $timeline->remarks : 'NA';
    }

    /**
     * Get class enum for the application status
     *
     * @return ApplicationStatusEnum
     */
    public function getApplicationStatusAttribute(): ApplicationStatusEnum
    {
        return ApplicationStatusEnum::fromId($this->status_id);
    }

    /**
     * Set status by id
     *
     * @param ApplicationStatusEnum $applicationSatus
     * @return void
     */
    public function setActivityTypeAttribute(ApplicationStatusEnum $applicationStatus): void
    {
        $this->status_id = $applicationStatus->id();
    }

    /**
     * Undocumented function
     *
     * @param Application $application
     * @return Application
     */
    public static function setMappings(Application $application): Application
    {
        $form = Form::find($application->form_id);
        if ($form->mappings) {
            $data = $application->data;
            $mappings = is_string($form->mappings) ? json_decode($form->mappings, true) : $form->mappings;
            foreach ($mappings as $key => $value) {
                $valueKeys = explode('.', $value);
                $result = $data;
                foreach ($valueKeys as $nextKey) {
                    if (property_exists($result, $nextKey)) {
                        $result = $result->$nextKey;
                    } else {
                        $result = null;
                        break;
                    }
                }
                $data->$key = $result;
            }
            $application->data = $data;
        }
        return $application;
    }

    /**
     * Let's fetch all timelines for the application
     * @return HasMany
     */
    public function meetingApplications()
    {
        return $this->hasMany(MeetingApplication::class);
    }

    /**
     * The meetings that belong to the applications.
     */
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_applications');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePendingApplications($query)
    {
        $rolesPendencies = $this->user()->roles()->select('roles.metadata')->get()->toArray();
        if (empty($rolesPendencies)) {
            return $query->where('created_by', Auth::id())
                ->where('status_id', 0);
        }
        $applicationStatuses = collect(array_map(function ($r) {
            return $r['metadata'] ? $r['metadata']->pendency_application_status_ids : [];
        }, $rolesPendencies))->flatten()->toArray();

        return empty($applicationStatuses) ? $query->where('region_id', 0) : $query->whereIn('status_id', $applicationStatuses);
    }

    /**
     * Scope a query to only sponsored applications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSponsored($query)
    {
        return $query->where('status_id', '>', ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id());
    }

    /**
     * Scope a query to only sanctioned applications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSanctioned($query)
    {
        return $query->where('status_id', '>', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id());
    }

    /**
     * Scope a query to only sanctioned applications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('status_id', ApplicationStatusEnum::LOAN_REJECTED->id());
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApprovedApplications($query)
    {

        if ($this->user()->isGm() || $this->user()->isEO()) {
            return $query->where('status_id', '>', ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id());
        }

        if ($this->user()->isNodalDIC()) {
            return $query->where('status_id', '>', ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id())->orWhere('status_id', ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id());
        }

        if ($this->user()->isBankManager() || $this->user()->isEO()) {
            return $query->where('status_id', '>', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id());
        }

        if ($this->user()->isNodalBank()) {
            return $query->where('status_id', '>', ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE->id());
        }

        return $query->where('status_id', 15)->where('created_by', Auth::id());
    }

    /**
     * Let's check Associate user for the application
     * @return BelongsTo
     */
    public function applicant()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Let's fetch all timelines for the application
     * @return HasMany
     */
    public function timelines()
    {
        return $this->hasMany(ApplicationTimeline::class);
    }

    /**
     * Let's check Associate user for the application
     */
    public function district()
    {
        if ($this->region_id > 15) {
            return $this->region()->select('parent_id AS id')->where('id', $this->region_id)->first();
        }

        return $this->region()->select('id')->where('type_id', 19)->first();
    }
    public function getDistrict()
    {
        return $this->region()->select('name')->where('type_id', 404)->first();
    }

    /**
     * Get the applications district wise
     * or
     * Where Auth is from same District
     */
    public function scopeForCurrentUser($query)
    {
        $records = $this->user()->getRoles();
        if ($this->user()->isBankManager()) {
            $branches = [];
            foreach ($records as $record) {
                if ($record->pivot->metadata) {
                    $metadata = json_decode($record->pivot->metadata);
                    $branches += property_exists($metadata, 'bank_branch_ids') ? $metadata->bank_branch_ids : [];
                }
            }
            $branches = array_unique($branches);
            return empty($branches) ? $query->where('region_id', 0) : $query->whereIn('data->finance->bank_branch_id', $branches);
        } elseif ($this->user()->isBankRO() || $this->user()->isNodalBank()) {
            $banks = [];
            $districts = [];
            foreach ($records as $record) {
                if ($record->pivot->metadata) {
                    $metadata = json_decode($record->pivot->metadata);
                    $banks += property_exists($metadata, 'bank_ids') ? $metadata->bank_ids : [];
                    $districts += property_exists($metadata, 'district_ids') ? $metadata->district_ids : [];
                }
            }
            
            if (empty($banks)) {
                if ($this->user()->isNodalBank()) {
                    if (!empty($districts)) {
                        $query->whereIn('region_id', $districts);
                    }
                } else {
                    $query->where('region_id', 0);
                }
            } else {
                $branches = BankBranch::whereIn('bank_id', $banks)->select('id')->get()->map(fn($b) => $b->id)->toArray();
                if (!empty($branches)) {
                    $query->whereIn('data->finance->bank_branch_id', $branches);
                    if (!empty($districts)) {
                        $query->whereIn('region_id', $districts);
                    }
                }
            }
        } elseif ($this->user()->isSuperAdmin()) {
            return $query;
        } else {
            $districts = [];
            foreach ($records as $record) {
                if ($record->pivot->metadata) {
                    $metadata = json_decode($record->pivot->metadata);
                    $districts += isset($metadata->district_ids) ? $metadata->district_ids : [];
                }
            }
            $districts = array_unique($districts);
            // dd($query->whereIn('region_id', $districts)->toSql());
            return empty($districts) ? $query->where('region_id', 0) : $query->whereIn('region_id', $districts);
        }
    }

    /* public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)->where('applications.id', '>', 25000);
    } */
}
