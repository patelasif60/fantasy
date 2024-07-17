@component('mail::message')

Hi {{ $log->user->first_name }}

Your rollover leagues process have been completed.

Thanks,<br>
{{ config('app.name') }}

@endcomponent
