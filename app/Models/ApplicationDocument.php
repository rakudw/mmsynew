<?php

namespace App\Models;

/**
 * @property int $application_id
 * @property int $document_id
 * @property int $document_type_id
 * @property string $document_name
 * @property Application $application
 * @property Document $document
 * @property DocumentType $documentType
 */
class ApplicationDocument extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'application_id',
        'document_id',
        'document_type_id',
        'document_name',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'extras' => 'object',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Form::class, 'application_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }
}
