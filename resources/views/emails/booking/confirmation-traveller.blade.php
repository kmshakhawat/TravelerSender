@component('mail::message')
<p style="font-weight: bold;">Hi {{ $data['traveller_name'] }},</p>
@component('mail::panel')
<p>Good news! A user has booked a delivery on your upcoming trip.</p>
<p>Here are the booking details:</p>
<p style="font-weight: 500">Booking Summary:</p>
<p>Trip Route: {{ $data['trip_from'] }} → {{ $data['trip_to'] }}</p>
<p>Sender Name: {{ $data['name'] }}</p>
<p>Traveller Name: {{ $data['traveller_name'] }}</p>
<p>Booking Date: {{ $data['created'] }}</p>
<p>You can view or manage your booking anytime through your dashboard:</p>
<p><a href="{{ $data['order_url'] }}" target="_blank">{{ $data['order_url'] }}</a></p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
