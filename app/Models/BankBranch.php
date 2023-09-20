<?php

namespace App\Models;

use App\Enums\RegionTypeEnum;
use App\Interfaces\CrudInterface;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

/**
 * @property string $name
 * @property string $address
 * @property int $district_id
 * @property int $bank_id
 * @property string $ifsc
 * @property ?string $prefix
 * @property Region $district
 * @property Bank $bank
 */
class BankBranch extends Base implements CrudInterface
{
    use HasJsonRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'district_id',
        'bank_id',
        'ifsc',
        'prefix',
    ];

    public function getDetailsAttribute()
    {
        $ifsc = $this->getIfsc();
        return "{$this->bank->name}, {$this->name} ({$ifsc}" . ($this->prefix ? " - {$this->prefix})" : ')');
    }

    public function getIfsc()
    {
        return $this->bank->ifsc ? $this->bank->ifsc : $this->ifsc;
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
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'data->finance->bank_branch_id');
    }

    public function getFormDesign():object {
        return (object)[(object)[
            'type' => 'input',
            'label' => 'Branch Name',
            'width' => '12',
            'helpText' => 'The name of the bank branch.',
            'attributes' => (object)[
                'name' => 'name',
                'required' => 'required',
                'autofocus' => 'autofocus',
            ]
        ], (object)[
            'type' => 'textarea',
            'label' => 'Address',
            'width' => '12',
            'noLabel' => true,
            'helpText' => 'The address of the bank branch.',
            'attributes' => (object)[
                'name' => 'address',
                'required' => 'required',
                'autofocus' => 'autofocus',
                'placeholder' => 'Branch address'
            ]
        ], (object)[
            'type' => 'select',
            'label' => 'District',
            'width' => '12',
            'helpText' => 'The district of the bank branch.',
            'attributes' => (object)[
                'data-options' => 'dbase:region(id,name)[type_id:' . RegionTypeEnum::DISTRICT->id() . ']',
                'name' => 'district_id',
                'required' => 'required',
            ]
        ], (object)[
            'type' => 'select',
            'label' => 'Bank',
            'width' => '12',
            'helpText' => 'The name of the bank.',
            'attributes' => (object)[
                'data-options' => 'dbase:bank(id,name)',
                'name' => 'bank_id',
                'required' => 'required',
            ],
        ], (object)[
            'type' => 'input',
            'label' => 'IFSC',
            'width' => '12',
            'helpText' => 'The IFSC of the bank branch.',
            'attributes' => (object)[
                'name' => 'ifsc',
                'required' => 'required',
            ],
        ], (object)[
            'type' => 'input',
            'label' => 'Prefix',
            'width' => '12',
            'helpText' => 'The prefix for the bank branch in case of multiple branches with same IFSC.',
            'attributes' => (object)[
                'name' => 'prefix',
            ],
        ]];
    }

    public function getRequestValidator():array {
        return [
            'name' => 'required|max:255',
            'address' => 'required|max:511',
            'district_id' => "required|numeric|exists:App\\Models\\Region,id",
            'bank_id' => "required|numeric|exists:App\\Models\\Bank,id",
            'ifsc' => 'required|max:15',
            'prefix' => 'nullable|max:7',
        ];
    }
}
