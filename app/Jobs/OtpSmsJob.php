<?php

namespace App\Jobs;

use App\Helpers\SMSHelper;
use App\Models\Otp;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OtpSmsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var App\Models\Otp
     */
    public Otp $otp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Otp $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(!SMSHelper::sendSMS($this->otp->identity, 'SUBSIDY_APPROVED', [$this->otp->code, route('otp.login', ['id' => $this->otp->id, 'hash' => md5(crypt($this->otp->code, $this->otp->id))])])) {
            throw new Exception('SMS was not sent! ' . SMSHelper::getResponse());
        }
    }
}
