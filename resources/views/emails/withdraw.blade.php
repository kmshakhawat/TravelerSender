@component('mail::message')
<p style="font-weight: bold">Hi {{ $data['name'] }},</p>
@component('mail::panel')
<p>We've received your withdrawal request for the amount of {{ $data['amount'] }}.</p>
<p>Our team is now processing your request, and you will be notified once the transaction is complete. Please allow up to 24 hours for the funds to reflect in your account.</p>
<p>If you have any questions or need help getting started, our support team is always here for you.</p>
@endcomponent
<p>Thank you for using our platform!</p>
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
