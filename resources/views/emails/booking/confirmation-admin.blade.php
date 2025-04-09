@component('mail::message')
<p style="font-weight: bold;">Hi Admin,</p>
@component('mail::panel')
<p>A new booking has just been made on the platform. Below are the details:</p>
<p style="font-weight: 500">Booking Summary:</p>
<p>Trip Route: {{ $data['trip_from'] }} → {{ $data['trip_to'] }}</p>
<p>Sender Name: {{ $data['name'] }}</p>
<p>Traveller Name: {{ $data['traveller_name'] }}</p>
<p>Booking Date: {{ $data['created'] }}</p>
<p>You can view or manage your booking anytime through your dashboard:</p>
<p><a href="{{ $data['url'] }}" target="_blank">{{ $data['url'] }}</a></p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
