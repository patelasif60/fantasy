@component('mail::message')

You have been invited to create an account on {{ config('app.name') }}

@component('mail::button', ['url' => route('auth.users.admin.invitation.show', ['token' => $user->invite->token])])
View invitation
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
