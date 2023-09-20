<?php

namespace App\Models;

use App\Enums\TypeEnum;

/**
 * @property string $name
 * @property string $type
 */
class Enum extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class, 'type_id');
    }

    /**
     * Get class enum for the enum type
     *
     * @return TypeEnum|null
     */
    public function getTypeEnumAttribute(): ?TypeEnum {
        $filteredEnum = array_values(array_filter(TypeEnum::cases(), function($et) {
            return $et->name == $this->type;
        }));
        return empty($filteredEnum) ? null : $filteredEnum[0];
    }

    /**
     * Set type by enum class
     *
     * @param TypeEnum $enumType
     * @return void
     */
    public function setTypeEnumAttribute(TypeEnum $enumType) {
        $this->type = $enumType->name;
    }
}
