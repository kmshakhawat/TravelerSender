@component('mail::message')
<p style="font-weight: bold;">Hi {{ $data['name'] }},</p>
@component('mail::panel')
<p>Thank you for booking a trip with {{ config('app.name') }}</p>
<p>Your booking has been successfully placed. The traveler has been notified, and you will be contacted shortly for the next steps.</p>
<p>Here are the details of your booking:</p>
<p style="font-weight: 500">Booking Summary:</p>
<p>Trip Route: {{ $data['trip_from'] }} → {{ $data['trip_to'] }}</p>
<p>Traveller Name: {{ $data['traveller_name'] }}</p>
<p>Booking Date: {{ $data['created'] }}</p>
<p>You can view or manage your booking anytime through your dashboard:</p>
<p><a href="{{ $data['url'] }}" target="_blank">{{ $data['url'] }}</a></p>
<p>If you have any questions, feel free to reach out to us at {{ config('app.admin.support') }}.</p>
<p>Thank you for trusting us with your delivery!</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
