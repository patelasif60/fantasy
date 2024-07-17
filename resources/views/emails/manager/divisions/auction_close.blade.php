@component('mail::message')

Hello {{$division->consumer->user->first_name}},<br>

Your league <strong>{{$division->name}}</strong> chairman has closed auction.<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
