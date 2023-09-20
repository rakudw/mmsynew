<?php

namespace App\Models;

use App\Events\ModelCreatingEvent;
use App\Events\ModelDeletingEvent;
use App\Events\ModelUpdatingEvent;
use App\Traits\DbModelTrait;
use Illuminate\Database\Eloquent\Model;

class Base extends Model {

    use DbModelTrait;

    protected $dispatchesEvents = [
        'creating' => ModelCreatingEvent::class,
        'updating' => ModelUpdatingEvent::class,
        'deleting' => ModelDeletingEvent::class,
    ];

    protected function user():User {
        return auth()->user();
    }
}