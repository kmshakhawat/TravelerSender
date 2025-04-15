@component('mail::message')
<p style="font-weight: bold">Hi Admin,</p>
@component('mail::panel')
<p>A new withdrawal request has been submitted by a traveller.</p>
<p style="font-weight: 500;">Here are the details:</p>
<ul>
<li>Traveller Name: {{ $data['traveller_name'] }}</li>
<li>Email: {{ $data['traveller_email'] }}</li>
<li>Amount: {{ $data['amount'] }}</li>
<li>Requested At: {{ $data['requested_at'] }}</li>
</ul>
@endcomponent
<p>Please <a href="{{ route('login') }}">log in</a> to the admin panel to review and process this withdrawal request.</p>
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
