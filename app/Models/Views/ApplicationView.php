<?php

namespace App\Models\Views;

use App\Enums\ActivityTypeEnum;
use App\Enums\ApplicationStatusEnum;
use App\Models\Activity;
use App\Models\ApplicationTimeline;
use App\Models\BankBranch;
use App\Models\Bank;
use App\Models\Enum;
use App\Models\Region;

/**
 * @property string $name
 * @property string $code
 * @property string $address
 * @property int $bank_id
 * @property string $bank_name
 * @property int $district_id
 * @property string $district_name
 * @property Region $district
 * @property Bank $bank
 */
class ApplicationView extends BaseView
{

    protected $table = 'view_applications';

    public function getSearchAbleColumns():array
    {
        return ['id', 'name', 'status', 'constitution_type', 'area_type', 'enterprise_district', 'enterprise_constituency', 'enterprise_tehsil', 'enterprise_block_town', 'enterprise_panchayat_ward', 'enterprise_address', 'enterprise_pincode', 'activity_type', 'activity', 'activity_detail', 'proposed_employment', 'applicant', 'mobile', 'email', 'guardian', 'owner_district', 'owner_constituency', 'owner_tehsil', 'owner_block_town', 'owner_panchayat_ward', 'owner_address', 'owner_pincode', 'birth_date', 'aadhaar', 'pan', 'marital_status', 'spouse_aadhaar', 'bank', 'bank_branch', 'bank_branch_ifsc', 'bank_branch_address'];
    }

    public function getUniqueIdAttribute()
    {
        if($this->id < 25000) {
            return 'RES' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
        }
        $region = $this->region;
        return 'MMSY-' . strtoupper(substr($region ? $region->name : 'NA', 0, 2)) . '-' . $this->id;
    }

    /**
     * Let's fetch all timelines for the application
     * @return HasMany
     */
    public function applicationTimelines()
    {
        return $this->hasMany(ApplicationTimeline::class, 'application_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bankBranch()
    {
        return $this->belongsTo(BankBranch::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(Region::class, 'district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicationStatus()
    {
        return $this->belongsTo(Enum::class, 'status_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank_branch()
    {
        return $this->belongsTo(BankBranch::class, 'bank_branch_id');
    }

    public function getAddressAttribute()
    {
        return implode(', ', array_filter([$this->enterprise_address, $this->enterprise_panchayat_ward ? $this->enterprise_panchayat_ward : null, $this->enterprise_block_town ? $this->enterprise_block_town : null, $this->enterprise_tehsil ? 'Tehsil ' . $this->enterprise_tehsil : null, 'Distt. ' . $this->enterprise_district])) . ' - ' . $this->enterprise_pincode;
    }

    public function getApplicantAddressAttribute()
    {
        return implode(', ', array_filter([$this->owner_address, $this->owner_panchayat_ward ? $this->owner_panchayat_ward : null, $this->owner_block_town ? $this->owner_block_town : null, $this->owner_tehsil ? 'Tehsil ' . $this->owner_tehsil : null, 'Distt. ' . $this->owner_district])) . ' - ' . $this->owner_pincode;
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
                    $branches += isset($metadata->bank_branch_ids) ? $metadata->bank_branch_ids : [];
                }
            }
            $branches = array_unique($branches);
            return empty($branches) ? $query->where('district_id', 0) : $query->whereIn('bank_branch_id', $branches);
        } elseif ($this->user()->isBankRO() || $this->user()->isNodalBank()) {
            $banks = [];
            $districts = [];
            if ($this->user()->isNodalBank()) {
                $districts = District::where('parent_id', 2)->pluck('id')->toArray();
            }
        
            foreach ($records as $record) {
                if ($record->pivot->metadata) {
                    $metadata = json_decode($record->pivot->metadata);
                    $banks += isset($metadata->bank_ids) ? $metadata->bank_ids : [];
                    if (!$this->user()->isNodalBank()) {
                        $districts += isset($metadata->district_ids) ? $metadata->district_ids : [];
                    }
                }
            }
            if (empty($banks)) {
                if ($this->user()->isNodalBank()) {
                    if(!empty($districts)) {
                        $query->whereIn('district_id', $districts);
                    }
                } else {
                    $query->where('district_id', 0);
                }
            } else {
                $branches = BankBranch::whereIn('bank_id', $banks)->select('id')->get()->map(fn($b) => $b->id)->toArray();
                if (!empty($branches)) {
                    $query->whereIn('bank_branch_id', $branches);
                    if (!empty($districts)) {
                        $query->whereIn('district_id', $districts);
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
            return empty($districts) ? $query->where('district_id', 0) : $query->whereIn('district_id', $districts);
        }
    }

    public function getProjectCostAttribute()
    {
        return $this->capital_expenditure + $this->working_capital;
    }

    public function getOwnContributionAmountAttribute()
    {
        return round($this->project_cost * (($this->own_contribution_percentage ?? 10) / 100));
    }

    public function getFinanceWorkingCapitalAttribute()
    {
        return $this->working_capital - ($this->working_capital * ($this->own_contribution_percentage ?? 10) / 100);
    }

    public function getTermLoanAttribute()
    {
        return $this->project_cost - $this->own_contribution_amount - $this->finance_working_capital;
    }

    /* public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)->where('view_applications.id', '>', 25000);
        return env('APP_ENV', 'local') == 'production' ? parent::newQuery($excludeDeleted)
           ->where('view_applications.id', '>', 25000) : parent::newQuery($excludeDeleted);
    } */
}
