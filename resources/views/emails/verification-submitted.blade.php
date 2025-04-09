@component('mail::message')
<p style="font-weight: bold;">Hi Admin,</p>
@component('mail::panel')
<p>A new verification request has just been submitted and is awaiting your review.</p>
<p>User Details:</p>
<p>Name: {{ $data['name'] }}</p>
<p>Email: {{ $data['email'] }}</p>
<p>Submission Date: {{ getDateFormat($data['date']) }}</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
