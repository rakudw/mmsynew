<?php

namespace App\Models;

class Setting extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value'
    ];

    public function getDataAttribute():mixed
    {
        return json_decode($this->value);
    }
}
