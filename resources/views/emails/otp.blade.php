@component('mail::message')
# MMSY Login OTP : {{ $otp->code }}

Your login OTP for MMSY Portal is <code>{{ $otp->code }}</code> and is valid till <code>{{ $otp->expires_at }}</code>. You can also login by clicking the link below.

@component('mail::button', ['url' => route('otp.login', ['id' => $otp->id, 'hash' => md5(crypt($otp->code, $otp->id))])])
Click Here to Login
@endcomponent

Thanks,<br>
Team {{ config('app.name') }}
@endcomponent
