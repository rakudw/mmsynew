<?php

namespace App\Models;

class Document extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mime',
        'content',
        'hash',
    ];
}
