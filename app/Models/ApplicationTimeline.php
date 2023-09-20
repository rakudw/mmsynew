<?php

namespace App\Models;

use App\Enums\ApplicationStatusEnum;

/**
 * @property int $application_id
 * @property int $old_status_id
 * @property int $new_status_id
 * @property string $remarks
 * @property ApplicationStatusEnum $old_status
 * @property ApplicationStatusEnum $new_status
 */
class ApplicationTimeline extends Base
{
    protected $fillable = ['application_id', 'old_status_id', 'new_status_id', 'remarks'];

    public function application(){
        return $this->belongsTo(Application::class);
    }

    public function creatorRole() {
        return $this->belongsTo(Role::class, 'creator_role_id');
    }

    public function getOldStatusAttribute() {
        return ApplicationStatusEnum::fromId($this->old_status_id);
    }

    public function getNewStatusAttribute() {
        return ApplicationStatusEnum::fromId($this->new_status_id);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::creating(function ($obj) {
            $userRoles = auth()->user() ? auth()->user()->roles : null;
            $obj->creator_role_id = ($userRoles && $userRoles->count() > 0) ? $userRoles->first()->id : null;
        });
    }
}
