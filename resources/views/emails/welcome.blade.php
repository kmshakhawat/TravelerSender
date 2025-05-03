@component('mail::message')
<p style="font-weight: bold">Hi {{ $data['name'] }},</p>
<img src="{{ asset('asset/img/email-welcome.jpg') }}" alt="Welcome" style="margin-bottom: 10px;">
<h3 style="font-size: 24px;text-align: center;color: #E63224;">Welcome to {{ config('app.name') }}</h3>
@component('mail::panel')
<p>Your registration was successful, and your account is now active. You can now log in and start exploring our services. If verification is required, please submit your verification details to unlock all features.</p>
<p style="font-weight: 500">👉 Next Steps:</p>
<ul>
<li>Log in to your account: <a href="{{ config('app.url').'/login' }}">{{ config('app.url').'/login' }}</a></li>
<li>Complete your profile: <a href="{{ config('app.url').'/profile' }}">{{ config('app.url').'/profile' }}</a></li>
<li>Submit verification: <a href="{{ config('app.url').'/verification' }}">{{ config('app.url').'/verification' }}</a></li>
</ul>
<p>If you have any questions or need help getting started, our support team is always here for you.</p>
<p>Thanks again for joining us. We look forward to being part of your journey!</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
