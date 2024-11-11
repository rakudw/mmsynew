<?php

namespace App\Models;

use App\Enums\ActivityTypeEnum;
use App\Interfaces\CrudInterface;

/**
 * @property string $name
 * @property int $type_id
 * @property bool $requires_address
 * @property bool $has_land_component
 * @property bool $has_building_component
 * @property ActivityTypeEnum $type
 */
class Activity extends Base implements CrudInterface
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type_id'
    ];

    protected $casts = [
        'has_land_component' => 'boolean',
        'has_building_component' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Enum::class, 'type_id');
    }

    /**
     * Get class enum for the activity type
     *
     * @return ActivityTypeEnum
     */
    public function getActivityTypeEnumAttribute():ActivityTypeEnum {
        return ActivityTypeEnum::fromId($this->type_id);
    }

    public function getFormDesign():object {
        return (object)[(object)[
            'type' => 'textarea',
            'label' => 'Activity Name',
            'width' => '12',
            'noLabel' => true,
            'helpText' => 'The name of the activity.',
            'attributes' => (object)[
                'name' => 'name',
                'required' => 'required',
                'autofocus' => 'autofocus',
                'placeholder' => 'Activity name',
            ]
        ], (object)[
            'type' => 'select',
            'label' => 'Type of Activity',
            'width' => '12',
            'helpText' => 'Type of the activity.',
            'attributes' => (object)[
                'data-options' => 'dbase:enum(id,name)[type:ACTIVITY_TYPE]',
                'name' => 'type_id',
                'required' => 'required'
            ]
        ]];
    }

    public function getRequestValidator():array {
        return [
            'name' => 'required|max:511',
            'type_id' => "required|numeric|exists:App\\Models\\Enum,id",
        ];
    }

    /**
     * Set type by enum class
     *
     * @param ActivityTypeEnum $activityType
     * @return void
     */
    public function setActivityTypeEnumAttribute(ActivityTypeEnum $activityType) {
        $this->type_id = $activityType->id();
    }
}
