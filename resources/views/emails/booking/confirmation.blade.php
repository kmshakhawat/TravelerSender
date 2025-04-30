@component('mail::message')
<p style="font-weight: bold;">Hi {{ $data['name'] }},</p>
@component('mail::panel')
<p>Thank you for booking a trip with {{ config('app.name') }}</p>
<p>Your booking has been successfully placed. The traveler has been notified.</p>
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

<h3>Booking Details Check</h3>
<p>Carefully review all booking details. If there are any issues with the pickup or delivery address or dates, immediately contact the traveller for clarification.</p>
<ul>
<li>Carefully review all booking details.</li>
<li>If there are any issues with the pickup or delivery address or dates, immediately contact the concerned person to clarify.</li>
</ul>
<h3>Parcel Collection Instructions</h3>
<ul>
<li><strong>Collection from Address:</strong><br>Contact the sender in advance to confirm an estimated arrival time for parcel collection.</li>
<li><strong>Flexible Meet:</strong><br>Coordinate the meeting details (date, time, and location) with the sender ahead of time.</li>
<li><strong>Send by Courier:</strong><br>If sending the parcel by courier, please provide the tracking details to the traveller beforehand, so they can monitor the shipment and arrange for timely collection.</li>
<li><strong>Send by Friend:</strong><br>If a friend is delivering the parcel, ensure you provide the 6-digit delivery OTP (sent to your email). Without the OTP, the parcel cannot be collected for security reasons.</li>
<li><strong>Send by Uber Driver:</strong><br>If an Uber driver is delivering the parcel, make sure you provide the 6-digit delivery OTP (sent to your email). Without the OTP, the parcel cannot be collected for security reasons.</li>
</ul>

<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
