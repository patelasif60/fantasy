@foreach($teamPlayers as $teamplayer)
<div class="row">
<table class="report-table">
    <caption class="team-title">
        <h3>
            {{$teamplayer['team']->name}} - 
            {{$teamplayer['team']->consumer->user->first_name}} {{$teamplayer['team']->consumer->user->last_name}}
        </h3>
        <strong>Your Team</strong>
    </caption>
    <tr>
        <th></th>
        <th>Player</th>
        <th>Club</th>
        <th>PLD</th>
        <th>GLS</th>
        <th>ASS</th>
        <th>CS</th>
        <th>GA</th>
        <th>WK</th>
        <th>MTH</th>
        <th>TOT</th>
    </tr>
    @foreach($teamplayer['activePlayers'] as $positions)
        @if(is_array($positions))
        @foreach($positions as $player)
            <tr>
                <td>{{$player['position']}}</td>
                <td>{{$player['player_first_name']}} {{$player['player_last_name']}}</td>
                <td>{{$player['short_code']}}</td>
                <td>{{ ($player['played']) ? $player['played']: 0}}</td>
                <td>{{ ($player['player_goals']) ? $player['player_goals']: 0}}</td>
                <td>{{ ($player['player_assists']) ? $player['player_assists']: 0}}</td>
                <td>{{ ($player['player_clean_sheet']) ? $player['player_clean_sheet']: 0}}</td>
                <td>{{ ($player['player_conceded']) ? $player['player_conceded']: 0}}</td>
                <td>{{$gameweek->number}}</td>
                <td>{{$currentMonth}}</td>
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
        <td>{{$player['position']}}</td>
        <td>{{$player['player_first_name']}} {{$player['player_last_name']}}</td>
        <td>{{$player['short_code']}}</td>
        <td>{{ ($player['played']) ? $player['played']: 0}}</td>
        <td>{{ ($player['player_goals']) ? $player['player_goals']: 0}}</td>
        <td>{{ ($player['player_assists']) ? $player['player_assists']: 0}}</td>
        <td>{{ ($player['player_clean_sheet']) ? $player['player_clean_sheet']: 0}}</td>
        <td>{{ ($player['player_conceded']) ? $player['player_conceded']: 0}}</td>
        <td>{{$gameweek->number}}</td>
        <td>{{$currentMonth}}</td>
        <td>{{ ($player['total']) ? $player['total']: 0}}</td>
    </tr>
    @endforeach
</table>
</div>

<div class="row">
<table class="report-table">
    <caption><h3>League Table</h3></caption>
    <tr>
        <th></th>
        <th>Team</th>
        <th>Manager</th>
        <th>GLS</th>
        <th>ASS</th>
        <th>CS</th>
        <th>GA</th>
        <th>WK</th>
        <th>MTH</th>
        <th>TOT</th>
    </tr>
    @foreach ($leagueTable as  $key => $leagueRow)
    <tr>
        <td>{{ ($key + 1) }}</td>
        <td>{{ $leagueRow['teamName'] }}</td>
        <td>{{ $leagueRow['first_name'] }} {{ $leagueRow['last_name'] }}</td>
        <td>{{ ($leagueRow['total_goal'])?$leagueRow['total_goal']:0 }}</td>
        <td>{{ ($leagueRow['total_assist'])?$leagueRow['total_assist']:0 }}</td>
        <td>{{ ($leagueRow['total_clean_sheet'])?$leagueRow['total_clean_sheet']:0 }}</td>
        <td>{{ ($leagueRow['total_conceded'])?$leagueRow['total_conceded']:0 }}</td>
        <td>{{ $gameweek->number }}</td>
        <td>{{ $currentMonth }}</td>
        <td>{{ ($leagueRow['total_point'])?$leagueRow['total_point']:0 }}</td>
    </tr>
    @endforeach
</table>
</div>

<div class="row sub-page">
<table width="100%" class="report-table">
    <caption><h3>League Series</h3></caption>
    <tr>
        <th></th>
        <th>Team</th>
        <th>P</th>
        <th>W</th>
        <th>D</th>
        <th>L</th>
        <th>F</th>
        <th>A</th>
        <th>Pts</th>
    </tr>
    @foreach(json_decode($leagueSeries) as  $key => $leagueRow)
    <tr>
        <td>{{ ($key + 1) }}</td>
        <td>{{ $leagueRow->teamName }}</td>
        <td>{{ ($leagueRow->plays)?$leagueRow->plays:0 }}</td>
        <td>{{ ($leagueRow->wins)?$leagueRow->wins:0 }}</td>
        <td>{{ ($leagueRow->draws)?$leagueRow->draws:0 }}</td>
        <td>{{ ($leagueRow->loses)?$leagueRow->loses:0 }}</td>
        <td>{{ ($leagueRow->points_for)?$leagueRow->points_for:0 }}</td>
        <td>{{ ($leagueRow->points_against)?$leagueRow->points_against:0 }}</td>
        <td>{{ ($leagueRow->team_points)?$leagueRow->team_points:0 }}</td>
    </tr>
    @endforeach
</table>
</div>
@endforeach
