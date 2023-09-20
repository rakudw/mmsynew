<?php

namespace App\Models;

/**
 * @property string $identity
 * @property string $code
 * @property DateTime $expires_at
 */
class Otp extends Base
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function booted()
    {
        parent::booted();

        static::creating(function (Otp $otp) {
            $otp->code = env('APP_DEBUG') ? 123456 : mt_rand(100000, 999990);
            $otp->expires_at = now()->addMinutes(10);
        });
    }

    public function isForEmail(): bool
    {
        return filter_var($this->identity, FILTER_VALIDATE_EMAIL);
    }

    public function isForMobile(): bool
    {
        return !$this->isForEmail();
    }
}
