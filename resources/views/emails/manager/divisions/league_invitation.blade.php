@component('mail::message')

You have been invited by <strong>{{$user->first_name . ' ' . $user->last_name}}</strong> 
to join <strong>{{$division->name}}</strong><br>

{{$invitationUrl}}<br>

@component('mail::button', ['url' => $invitationUrl])
Join league
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
