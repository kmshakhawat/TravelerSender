@component('mail::message')
<p style="font-weight: bold;">Hi Admin,</p>
@component('mail::panel')
<p>A new trip has just been added by a traveler on the platform. Please review the details below:</p>
<p style="font-weight: 500">Traveller Information:</p>
<p>Name: {{ $data['name'] }}</p>
<p>Email: {{ $data['email'] }}</p>
<p style="font-weight: 500">Trip Details:</p>
<p>From: {{ $data['trip_from'] }}</p>
<p>To: {{ $data['trip_to'] }}</p>
<p>Departure Date: {{ getDateFormat($data['departure_date']) }}</p>
<p>Arrival Date: {{ getDateFormat($data['arrival_date']) }}</p>
<p>Date Added: {{ getDateFormat($data['created']) }}</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
