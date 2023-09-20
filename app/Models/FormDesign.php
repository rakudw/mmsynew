<?php

namespace App\Models;

/**
 * @property string $name
 * @property string $slug
 * @property int $form_id
 * @property array $design
 * @property ?array $validations
 * @property ?array $assets
 * @property int $order
 * @property Form $form
 */
class FormDesign extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'form_id',
        'design',
        'validations',
        'assets',
        'order',
    ];

    protected $casts = [
        'design' => 'object',
        'validations' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
