@component('mail::message')
<p style="font-weight: bold">Hi {{ $data['name'] }},</p>
<img src="{{ asset('asset/img/email-welcome.jpg') }}" alt="Welcome" style="margin-bottom: 10px;">
<h3 style="font-size: 24px;text-align: center;color: #E63224;">Welcome to {{ config('app.name') }}</h3>
@component('mail::panel')
<p>Your password reset successfully!</p>
<p style="font-weight: 500">👉 Next Steps:</p>
<ul style="margin-top: 30px;">
<li>Log in to your account: <a href="{{ config('app.url').'/login' }}">{{ config('app.url').'/login' }}</a></li>
</ul>
<p>If you have any questions or need help getting started, our support team is always here for you.</p>
<p>Thanks again for joining us. We look forward to being part of your journey!</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
