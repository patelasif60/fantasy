@component('mail::message')

Hi {{ $team->first_name }}

Your league <strong>{{ $team->divisionNm }}</strong> round starts now.

Thanks,<br>
{{ config('app.name') }}

@endcomponent
