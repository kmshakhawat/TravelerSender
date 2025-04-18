@component('mail::message')
@component('mail::panel')
<p style="font-weight: bold;">Hi {{ $data['name'] }},</p>
<p>Great news! Your verification has been successfully completed and approved.</p>
<p>You can now access all features of your account without any restrictions. Thank you for your cooperation and for helping us keep our platform secure.</p>
<p><strong>Login Details:</strong></p>
<ul>
    <li>Email: {{ $data['email'] }}</li>
    <li>Password: ********</li>
    <li>Login URL: <a target="_blank" href="{{ $data['login_url'] }}">{{ $data['login_url'] }}</a></li>
</ul>

<p>If you have any questions or need assistance, don’t hesitate to reach out to our support team.</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
