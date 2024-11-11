<?php

namespace App\Models;

/**
 * @property string $name
 * @property int $region_id
 * @property array mappings
 * @property ?int $parent_id
 * @property ?Form $parent
 */
class Form extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'region_id',
        'parent_id',
    ];

    protected $casts = [
        'mappings' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Form::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function formDocumentTypes()
    {
        return $this->hasMany(FormDocumentType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formDesigns()
    {
        return $this->hasMany(FormDesign::class);
    }
}
