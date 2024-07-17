<div class="row">
@foreach($teamPlayers as $teamplayer)
<table class="player-table">
    <caption class="team-title"><strong>{{$teamplayer['team']->consumer->user->first_name}} {{$teamplayer['team']->consumer->user->last_name}}</strong><br/>{{$teamplayer['team']->name}}</caption>
    <tr>
        <th>Player</th>
        <th>WK</th>
        <th>TOT</th>
    </tr>
    @foreach($teamplayer['activePlayers'] as $positions)
        @if(is_array($positions))
        @foreach($positions as $player)
            <tr>
                <td>{{get_player_name('firstNameFirstCharAndFullLastName', $player['player_first_name'], $player['player_last_name'])}}</td>
                <td>{{$gameweek->number}}</td>
                <td>{{ ($player['total']) ? $player['total']: 0}}</td>
            </tr>
        @endforeach
        @endif
    @endforeach

    <tr>
        <td colspan='3' class="title">Substitutes</td>
    </tr>

    @foreach($teamplayer['subPlayers'] as $player)
            <tr>

                <td>{{get_player_name('firstNameFirstCharAndFullLastName', $player['player_first_name'], $player['player_last_name'])}}</td>
                <td>{{$gameweek->number}}</td>
                <td>{{ ($player['total']) ? $player['total']: 0}}</td>
            </tr>
    @endforeach
</table>
@endforeach
</div>
