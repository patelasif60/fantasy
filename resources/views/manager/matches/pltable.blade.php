<div class="table-responsive">
    <table class="table custom-table table-hover m-0 fixed-column premier-league-table">
        <thead class="thead-dark">
            <tr>
                <th class="text-center align-bottom" rowspan="2">pos</th>
                <th class="align-bottom" rowspan="2">Club</th>
                <th class="text-center align-bottom" rowspan="2">P</th>
                <th class="text-center align-bottom" rowspan="2">W</th>
                <th class="text-center align-bottom" rowspan="2">D</th>
                <th class="text-center align-bottom" rowspan="2">L</th>
                <th class="text-center align-bottom isMobile" rowspan="2">F</th>
                <th class="text-center align-bottom isMobile" rowspan="2">A</th>
                {{-- <th class="text-center align-bottom isMobile" rowspan="2">GD</th> --}}
                <th class="text-center border-bottom-0 isMobileDispNone" colspan="4">Overall</th>
                <th class="text-center border-bottom-0 isMobileDispNone" colspan="4">Home</th>
                <th class="text-center border-bottom-0 isMobileDispNone" colspan="4">Away</th>
                <th class="text-center align-bottom" rowspan="2">PTS</th>
            </tr>
            <tr class="sub-header isMobileDispNone">
                <th class="text-center">F</th>
                <th class="text-center">A</th>
                <th class="text-center">GD</th>
                <th class="text-center">CS</th>
                <th class="text-center">F</th>
                <th class="text-center">A</th>
                <th class="text-center">GD</th>
                <th class="text-center">CS</th>
                <th class="text-center">F</th>
                <th class="text-center">A</th>
                <th class="text-center">GD</th>
                <th class="text-center">CS</th>
            </tr>
        </thead>
        <tbody>
        	@forelse($clubs as $index => $club)
    			<tr>
    				<td class="text-center">{{ $index + 1}}</td>
    				<td> <div class="player-tshirt icon-18 {{ strtolower($club['short_code']).'_player' }} mr-1"></div> {{ $club['club'] }} </td>
    				<td class="text-center">{{ $club['played'] }}</td>
    				<td class="text-center">{{ $club['won'] }}</td>
                    <td class="text-center">{{ $club['drawn'] }}</td>
                    <td class="text-center">{{ $club['loss'] }}</td>
                    <td class="text-center isMobile">{{ $club['goal'] }}</td>
                    <td class="text-center isMobile">{{ $club['ga'] }}</td>
                    {{-- <td class="text-center isMobile">{{ $club['gd'] }}</td> --}}
    				<td class="text-center isMobileDispNone">{{ $club['goal'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['ga'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['gd'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['cs'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['home_goal'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['home_ga'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['home_gd'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['home_cs'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['away_goal'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['away_ga'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['away_gd'] }}</td>
    				<td class="text-center isMobileDispNone">{{ $club['away_cs'] }}</td>
    				<td class="text-center">{{ $club['points'] }}</td>
    			</tr>
    		@empty
                <tr>
                    <td colspan="21" align="center">No Data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>