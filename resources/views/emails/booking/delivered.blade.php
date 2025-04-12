@component('mail::message')
<p style="font-weight: bold;">Hi {{ $data['name'] }},</p>
@component('mail::panel')
<p>We’re happy to inform you that your parcel has been successfully delivered!</p>
<p style="font-weight: 500">Delivery Details:</p>
<p>Trip Route: {{ $data['trip_from'] }} → {{ $data['trip_to'] }}</p>
<p>Delivered By: {{ $data['traveller_name'] }}</p>
<p>Delivery Date: {{ $data['delivery_date'] }}</p>
@endcomponent
@component('mail::panel')
<p>We hope your parcel has been delivered safely! To help us improve our services and recognize exceptional travelers, we’d love for you to rate your experience.</p>
<p>Please take a moment to rate the traveler who delivered your parcel:</p>
<p><a href="{{ $data['rating_url'] }}" target="_blank">{{ $data['rating_url'] }}</a></p>
<p></p>
@endcomponent
<p>Thank you for using {{ config('app.name') }}. We hope you had a smooth experience!</p>
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
