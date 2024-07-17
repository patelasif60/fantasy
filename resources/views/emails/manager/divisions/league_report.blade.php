@component('mail::message')

Dear {{$message['displayName']}},
<br>
Here's the  Report of League -  {{$message['divisionName']}} for the duration of {{$message['start']}} to {{$message['end']}} as requested by you.
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
