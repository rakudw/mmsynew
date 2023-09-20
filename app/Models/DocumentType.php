<?php

namespace App\Models;

/**
 * @property string $name
 * @property string $mime
 */
class DocumentType extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mime',
    ];
}
