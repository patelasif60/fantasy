@component('mail::message')

Dear Chairman/Manager,
<br>
Gentle Reminder to Pay. There exist teams in League - {{$emailDetails['division']->name}}, which are pending payment.
<br>

@component('mail::button', ['url' => $emailDetails['paymentURL']])
Get Started
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
