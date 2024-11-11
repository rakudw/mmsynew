<?php

namespace App\Models;

use App\Enums\ApplicationStatusEnum;
use App\Enums\BankTypeEnum;
use App\Enums\CacheKeyEnum;
use App\Helpers\CacheHelper;
use App\Interfaces\CrudInterface;

/**
 * @property string $name
 * @property int $type_id
 * @property Enum $type
 */
class Bank extends Base implements CrudInterface
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type_id',
        'ifsc',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Enum::class, 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bankBranches()
    {
        return $this->hasMany(BankBranch::class);
    }

    public static function throughCache($id):?Bank
    {
        $bank = collect(CacheHelper::cached(CacheKeyEnum::ALL_BANKS))->where('id', $id)->first();
        return $bank ? new Bank([
            'name' => $bank['name'],
            'type_id' => $bank['type_id'],
        ]) : Bank::find($id);
    }

    public function getApplicationsAttribute()
    {
        $bank = Bank::throughCache($this->id);

        return Application::forCurrentUser()
                    ->whereIn('data->finance->bank_branch_id', BankBranch::where('bank_id', $this->id)
                    ->select('id')->get()
                    ->map(fn($b) => $b->id)->toArray());
    }

    /**
     * Get class enum for the activity type
     *
     * @return BankTypeEnum
     */
    public function getBankTypeEnumAttribute(): BankTypeEnum
    {
        return BankTypeEnum::fromId($this->type_id);
    }

    public function getFormDesign():object
    {
        return (object)[(object)[
            'type' => 'input',
            'label' => 'Bank Name',
            'width' => '12',
            'helpText' => 'The name of the bank.',
            'attributes' => (object)[
                'name' => 'name',
                'required' => 'required',
                'autofocus' => 'autofocus'
            ]
        ], (object)[
            'type' => 'select',
            'label' => 'Type of Bank',
            'width' => '12',
            'helpText' => 'Type of the bank.',
            'attributes' => (object)[
                'data-options' => 'dbase:enum(id,name)[type:BANK_TYPE]',
                'name' => 'type_id',
                'required' => 'required'
            ]
        ], (object)[
            'type' => 'input',
            'label' => 'IFSC',
            'width' => '12',
            'helpText' => 'The IFSC of the bank branch.',
            'attributes' => (object)[
                'name' => 'ifsc',
                'required' => 'required',
            ],
        ]];
    }

    public function getRequestValidator():array
    {
        return [
            'name' => 'required|max:255',
            'type_id' => "required|numeric|exists:App\\Models\\Enum,id",
            'ifsc' => 'nullable|max:15',
        ];
    }

    /**
     * Set type by enum class
     *
     * @param BankTypeEnum $bankType
     * @return void
     */
    public function setBankTypeEnumAttribute(BankTypeEnum $bankType)
    {
        $this->type_id = $bankType->id();
    }
}
