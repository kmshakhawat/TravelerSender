@component('mail::message')
<p style="font-weight: bold">Hi {{ $data['name'] }},</p>
@component('mail::panel')
<p>We'’'re pleased to inform you that your withdrawal request has been processed and the payment has been successfully completed.</p>
<p>Here are the details of your transaction:</p>
<ul>
    <li>Traveller Name: {{ $data['traveller_name'] }}</li>
    <li>Email: {{ $data['traveller_email'] }}</li>
    <li>Amount: {{ $data['amount'] }}</li>
    <li>Requested At: {{ $data['requested_at'] }}</li>
</ul>
<p>The funds should reflect in your account shortly, depending on your payment provider's processing time.</p>
<p>If you have any questions or notice any discrepancies, please don't hesitate to contact us.</p>
@endcomponent
<p>Thank you for using our platform!</p>
<p style="font-weight: 700;margin-top: 50px;">Your {{ config('app.name') }} Team.</p>
@endcomponent
