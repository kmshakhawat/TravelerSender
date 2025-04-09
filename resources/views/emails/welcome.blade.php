@component('mail::message')
<p style="font-weight: bold">Hi {{ $data['name'] }},</p>
@component('mail::panel')
<p>Welcome to {{ config('app.name') }} – we're thrilled to have you on board!</p>
<p>Your registration was successful, and your account is now active. You can now log in and start exploring our services. If verification is required, please submit your verification details to unlock all features.</p>
<p style="font-weight: 500">👉 Next Steps:</p>
<ul>
<li>Log in to your account: {{ config('app.url').'/login' }}</li>
<li>Complete your profile {{ config('app.url').'/profile' }}</li>
<li>Submit verification {{ config('app.url').'/verification' }}</li>
</ul>
<p>If you have any questions or need help getting started, our support team is always here for you.</p>
<p>Thanks again for joining us. We look forward to being part of your journey!</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
