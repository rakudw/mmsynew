<?php

namespace App\Helpers;

use App\Models\User;

abstract class BaseHelper
{

    public static function currentUser(): User
    {
        return auth()->user();
    }
}
