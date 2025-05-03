@component('mail::message')
<img src="{{ asset('asset/img/email-otp.jpg') }}" alt="OTP" style="margin-bottom: 10px;">
<p>To authenticate, please use the following:</p>
<p>One Time Password (OTP):</p>
@component('mail::panel')
<p
style="
margin: 0;
font-size: 40px;
font-weight: 600;
text-align: center;
color: #ff2d20;
"
>{{ $data['otp'] }}</p>
@endcomponent
<p>This OTP will expire in 7 minutes.</p>

<p style="font-size: 14px">DO NOT share this code with anyone.<br>
If you have not made this request, please contact us.</p>
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>

@endcomponent
