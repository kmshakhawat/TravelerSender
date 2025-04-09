@component('mail::message')
<p style="font-weight: bold;">Hi {{ $data['name'] }},</p>
@component('mail::panel')
<p>Thank you for adding your trip to {{ config('app.name') }}</p>
<p>Your trip is now visible to users who may be looking to send parcels along this route. You will be notified if anyone shows interest or sends a request.</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
