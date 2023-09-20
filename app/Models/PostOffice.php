<?php

namespace App\Models;

/**
 * @property string $name
 * @property string $pincode
 * @property int $district_id
 * @property int $block_id
 * @property Region $district
 * @property Region $block
 */
class PostOffice extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'pincode',
        'district_id',
        'block_id',
    ];

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
    public function block()
    {
        return $this->belongsTo(Region::class, 'block_id');
    }
}
