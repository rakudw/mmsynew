<?php

namespace App\Models\Views;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BaseView extends Model {

    protected function user():User {
        return auth()->user();
    }
}