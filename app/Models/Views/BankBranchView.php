<?php

namespace App\Models\Views;

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
class BankBranchView extends BaseView
{

    protected $table = 'view_bank_branches';

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
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
