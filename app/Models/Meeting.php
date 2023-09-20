<?php

namespace App\Models;

class Meeting extends Base
{
    protected $fillable = ['id', 'title', 'district_id', 'datetime', 'was_conducted', 'chair_person', 'created_by', 'remarks', 'updated_by', 'created_at'];

    protected $casts = [
        'was_conducted' => 'boolean',
    ];

    public function getUniqueIdAttribute() {
        $district = $this->district;
        return 'MT-' . strtoupper(substr($district ? $district->name : 'NA', 0, 2)) . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'meeting_applications');
    }

    /**
     * Let's fetch all timelines for the application
     * @return HasMany
     */
    public function meetingApplications()
    {
        return $this->hasMany(MeetingApplication::class);
    }

    public function district()
    {
        return $this->belongsTo(Region::class);
    }

    public function newQuery($excludeDeleted = true) {
        return env('APP_ENV', 'local') == 'production'
            ? parent::newQuery($excludeDeleted)
                ->where('meetings.id', '>', 1000)
            : parent::newQuery($excludeDeleted);
    }
}
