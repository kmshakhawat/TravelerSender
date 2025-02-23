@component('mail::message')
@component('mail::panel')
<h2 style="font-size: 30px;font-weight: 600;color: #000;">Welcome</h2>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
