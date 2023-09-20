<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \DateTimeInterface $date
 * @property string $description
 * @property boolean $is_holiday
 * @property boolean $should_flash
 * @property string $html
 */
class Event extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'description',
        'is_holiday',
        'should_flash',
        'html',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'is_holiday' => 'boolean',
        'should_flash' => 'boolean',
    ];

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTodays($query)
    {
        return $query->where('date', date('Y-m-d'));
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFlashable($query)
    {
        return $query->where('should_flash', true);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHolidays($query)
    {
        return $query->where('is_holiday', true);
    }
}
