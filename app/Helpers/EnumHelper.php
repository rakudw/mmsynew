<?php

namespace App\Helpers;

use App\Enums\CacheKeyEnum;
use App\Models\Enum;

class EnumHelper
{
    public static function lookup(int $id):mixed {
        return collect(CacheHelper::cached(CacheKeyEnum::ALL_ENUMS))->where('id', $id)
        ->firstOrFail();
    }

    public static function toId(string $name):int {
        $first = collect(CacheHelper::cached(CacheKeyEnum::ALL_ENUMS))->where(function($e) use($name) {
            return $e['name'] == $name;
        })->first();
        if ($first) {
            return $first['id'];
        }
        return null;
    }
}