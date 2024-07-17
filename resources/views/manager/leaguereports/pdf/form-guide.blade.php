@if(isset($formGuide))
<div class="row">
<h2>Form Guide</h2>
@foreach($formGuide as $key => $positionPlayers)
<table class="position-table">
    <tr>
        <th colspan = "9">{{ucfirst(str_replace('_', ' ', $key))}}</th>
    </tr>
    <tr>
        <th></th>
        <th>Club</th>
        <th>P</th>
        <th>G</th>
        <th>A</th>
        <th>CS</th>
        <th>GA</th>
        <th>Mth</th>
        <th>Tot</th>
    </tr>
    @foreach($positionPlayers as $player)
    <tr>
        <td>{{get_player_name('firstNameFirstCharAndFullLastName', $player['player_first_name'], $player['player_last_name'])}}</td>
        <td>{{$player['club_short']}}</td>
        <td>{{($player['played'])?$player['played']:0}}</td>
        <td>{{$player['goal']}}</td>
        <td>{{$player['assist']}}</td>
        <td>{{$player['clean_sheet']}}</td>
        <td>{{$player['conceded']}}</td>
        <td>{{$currentMonth}}</td>
        <td>{{$player['total']}}</td>
    </tr>
    @endforeach
</table>
@endforeach
</div>
@endif
