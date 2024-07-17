@if(isset($leagueTable))
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
    @foreach ($leagueTable as $key => $leagueRow)

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
@endif
@if(isset($monthlyForm))
<div class="row sub-page">
<table width="100%" class="report-table">
    <caption><h3>Monthy Form</h3></caption>
    <tr>
        <th></th>
        <th>Team</th>
        @foreach($months as $month)
            <td class="title">{{$month}}</td>
        @endforeach
    </tr>

   @foreach(json_decode($monthlyForm) as $key => $row)
    <tr>
        <td>{{ ($key + 1) }}</td>
        <td>{{$row->teamName}}</td>
        @foreach($months as $month)
            <td>{{($month == 'Dec') ? ($row->Dece)?$row->Dece:0: (($row->$month)?$row->$month:0)}}</td>
        @endforeach
   @endforeach
</table>
</div>
@endif

@if(isset($leagueSeries))
<div class="row">
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
    @if(count(json_decode($leagueSeries))>0)
    @foreach(json_decode($leagueSeries) as $key => $leagueRow)

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
    @else
        <tr>
            <td colspan="9" align="center"> No Data Found </td>
        </tr>
    @endif
</table>
</div>
@endif