@component('mail::message')
# MMSY Login OTP : {{ $otp->code }}

Your OTP for MMSY Portal is <code>{{ $otp->code }}</code> and is valid till <code>{{ $otp->expires_at }}</code>.



Thanks,<br>
Team {{ config('app.name') }}
@endcomponent
