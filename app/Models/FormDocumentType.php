<?php

namespace App\Models;

/**
 * @property int $form_id
 * @property int $document_type_id
 * @property int $order
 * @property bool $is_required
 * @property object $extras
 * @property Form $form
 * @property DocumentType $form
 */
class FormDocumentType extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'form_id',
        'document_type_id',
        'order',
        'is_required',
        'extras',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'extras' => 'object',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }
}
