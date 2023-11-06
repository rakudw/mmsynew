<?php

namespace App\Mail;

use App\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var App\Models\Otp
     */
    public $otp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Otp $otp)
    {
        $this->otp = $otp;
        $this->subject = trans(":code is your OTP", ['code' => $otp->code, 'color' => 'info']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.otp_verify');
    }
}
