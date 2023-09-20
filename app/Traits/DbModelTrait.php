<?php

namespace App\Traits;

use App\Models\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\User;

/**
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property DateTime $deleted_at
 * @property User $creator
 * @property User $updater
 * @property User $deletor
 */
trait DbModelTrait
{

    use HasFactory, Notifiable, SoftDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletor()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Help setup the mappings from the form data.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::creating(function (&$model)
        {
            $model->created_by = auth()->user() ? auth()->id() : 0;
            $model->created_at = now();
        });

        static::updating(function (&$model)
        {
            $model->updated_by = auth()->user() ? auth()->id() : 0;
            $model->updated_at = now();
        });

        static::deleting(function (&$model)
        {
            $model->deleted_by = auth()->user() ? auth()->id() : 0;
            $model->deleted_at = now();
        });
    }
}