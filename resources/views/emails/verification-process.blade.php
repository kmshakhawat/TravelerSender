@component('mail::message')
<p style="font-weight: bold;">Hi {{ $data['name'] }},</p>
@component('mail::panel')
<p>Thank you for submitting your verification details.</p>
<p>We’ve received your information and our team is currently reviewing it. This process usually takes 24-48 hours. You will receive an update once your verification is complete.</p>
<p>If you have any questions in the meantime, feel free to contact us at [support email or phone number].</p>
<p>Thank you for your patience.</p>
@endcomponent
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
