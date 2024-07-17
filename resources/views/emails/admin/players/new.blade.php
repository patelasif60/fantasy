@component('mail::message')

Following is the list of players newly added.

@component('mail::table')
| Player name | Club  | Position |
| ------------|:-----:|:--------:|
@foreach ($players as $player)
| {{ $player['name'] }} | {{ $player['club'] }} | {{ $player['position'] }} |
@endforeach
@endcomponent

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
