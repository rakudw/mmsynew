<?php

namespace App\Models;

class MeetingApplication extends Base
{

    protected $fillable = ['meeting_id', 'application_id', 'remarks', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(){
        return $this->belongsTo(Region::class);
    }
}
