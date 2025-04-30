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

<h3>Booking Details Check</h3>
<ul>
<li>Carefully review all booking details.</li>
<li>If there are any issues with the pickup or delivery address or dates, immediately contact the concerned person to clarify.</li>
</ul>
<h3>Parcel Collection Instructions</h3>
<ul>
<li><strong>Collection from Address:</strong><br>Contact the sender in advance to confirm a possible arrival time for the collection.</li>
<li><strong>Flexible Meet:</strong><br>Arrange the meeting details (date, time, and location) with the sender ahead of time.</li>
<li><strong>Send by Courier:</strong><br>If the sender is using a courier service, request the tracking details before your travel date.</li>
<li><strong>Send by Friend:</strong><br>Ask for full information about the person delivering the parcel, including the date and time of handover.<br>Make sure the friend can provide the 6-digit OTP when giving you the parcel.</li>
<li><strong>Send by Uber Driver:</strong><br>Request full details about the Uber driver beforehand.<br>Ensure that either the sender or the driver provides the 6-digit OTP at the time of parcel handover.</li>
</ul>
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
