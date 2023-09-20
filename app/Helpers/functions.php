<?php

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

if(!function_exists('setting')) {

    function setting(string $name, mixed $value = null, $default = null):mixed {
        $setting = Setting::where('name', $name)->first();
        if(is_null($value)) {
            if($setting) {
                return $setting->data; 
            }
            if(!is_null($default)) {
                setting($name, $default);
                return $default;
            }
            return null;
        } else {
            if($setting) {
                $setting->update(['value' => json_encode($value)]);
                return $setting;
            } else {
                return Setting::create([
                    'name' => $name,
                    'value' => json_encode($value),
                ]);
            }
        }
    }
}

if (!function_exists('userExistsInOldPortal')) {
    function userExistsInOldPortal()
    {
        $user = auth()->user();
       return 0;
        return ($user->isBankManager() ?
            DB::connection('old-mysql')->table('tb_branch_details')->where('bd_username', $user->email)->count() :
            DB::connection('old-mysql')->table('tb_officers_login')->where('ol_username', $user->email)->count()) > 0;
    }
}

if (!function_exists('oldPortalLoginToken')) {
    function oldPortalLoginToken()
    {
        $user = auth()->user();
        return openssl_encrypt(json_encode([
            'email' => $user->email,
            'type' => $user->isBankManager() ? 'bank' : 'officer',
            'time' => time(),
        ]), 'AES-128-CTR', 'Mmsy@2022', 0, '1234567891011121');
    }
}

