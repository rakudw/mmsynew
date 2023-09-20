<?php

namespace App\Helpers;

use App\Enums\CacheKeyEnum;
use App\Models\Activity;
use App\Models\Bank;
use App\Models\Enum;
use App\Models\Region;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    private static $_mappings = [
        'ALL_ENUMS' => [
            'callback' => 'allEnums',
            'ttl' => 86400,
        ], 'ALL_ROLES' => [
            'callback' => 'allRoles',
            'ttl' => 86400,
        ], 'ALL_REGIONS' => [
            'callback' => 'allRegions',
            'ttl' => 86400,
        ], 'ALL_BANKS' => [
            'callback' => 'allBanks',
            'ttl' => 86400,
        ], 'ALL_ACTIVITIES' => [
            'callback' => 'allActivities',
            'ttl' => 86400,
        ],
    ];

    public static function cached(CacheKeyEnum $key)
    {
        if (isset(self::$_mappings[$key->name])) {
            return call_user_func_array([__CLASS__, 'stored'],
                [$key, function() use($key) {
                    return call_user_func([__CLASS__, self::$_mappings[$key->name]['callback']]);
                },
                isset(self::$_mappings[$key->name]['ttl'])
                ? self::$_mappings[$key->name]['ttl']
                : 3600]);
        }
    }

    public static function purge(CacheKeyEnum $key = null) {
        is_null($key) ? Cache::flush() : Cache::forget($key->name);
    }

    private static function stored(CacheKeyEnum $key, callable $callback, int $seconds = 3600)
    {
        return Cache::remember($key->name, $seconds, $callback);
    }

    private static function allEnums()
    {
        return Enum::all()->toArray();
    }

    private static function allRoles()
    {
        return Role::all()->toArray();
    }

    private static function allRegions()
    {
        return Region::all()->toArray();
    }

    private static function allActivities()
    {
        return Activity::all()->toArray();
    }

    private static function allBanks()
    {
        return Bank::with('bankBranches')->get()->toArray();
    }
}
