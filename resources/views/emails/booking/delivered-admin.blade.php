@component('mail::message')
<p style="font-weight: bold;">Hi Admin,</p>
@component('mail::panel')
<p>A parcel delivery has been marked as completed on the platform. Here are the details:</p>
<p>Sender Name: {{ $data['name'] }}</p>
<p>Trip Route: {{ $data['trip_from'] }} → {{ $data['trip_to'] }}</p>
<p>Delivered By: {{ $data['traveller_name'] }}</p>
<p>Delivery Date: {{ $data['delivery'] }}</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
