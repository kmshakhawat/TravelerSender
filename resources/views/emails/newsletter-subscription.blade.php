@component('mail::message')
<p>Dear <strong>{{ $data['name'] }}</strong>,</p>
@component('mail::panel')
<p>Thank you for subscribing to {{ config('app.name') }}'s newsletter! We’re thrilled to have you join our community.</p>
<p>As a subscriber, you’ll be among the first to know about:</p>
<ul>
<li>Exclusive offers and discounts</li>
<li>Latest news and updates</li>
<li>Expert insights and tips</li>
</ul>
<p>Keep an eye on your inbox for exciting content coming your way soon!</p>
<p>If you have any questions or feedback, feel free to reach out at {{ config('app.admin.support') }}. We're here to make your experience exceptional.</p>
<p>Welcome aboard, and thank you for connecting with us!</p>
@endcomponent


<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
