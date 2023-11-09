<?php

namespace App\Traits;

use App\Enums\CacheKeyEnum;
use App\Helpers\CacheHelper;
use App\Helpers\EnumHelper;

trait DbEnumTrait
{

    /**
     * Get the enums table entry for the record
     *
     * @return int
     */
    public function id():int {
        $first = collect(CacheHelper::cached(CacheKeyEnum::ALL_ENUMS))->where(function($e) {
            
            return $e['name'] == $this->value;
        })->first();
        if($first) {
            return $first['id'];
        }
        return 0;
    }

    /**
     * Get the class enum from id of enums table
     *
     * @param integer $id
     * @return mixed
     */
    public static function fromId(int $id) {
        return call_user_func_array([__class__, 'from'], [EnumHelper::lookup($id)['name']]);
    }
}