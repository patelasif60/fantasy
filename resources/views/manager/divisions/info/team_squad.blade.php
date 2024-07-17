<div class="table-responsive">
    <table class="table custom-table">
        @foreach([true,false] as $a)
            <thead class="thead-dark">
                <tr>
                    <th>Player</th>
                    <th>Club</th>
                    <th>WK</th>
                    <th>MTH</th>
                    <th>TOT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($players->where('is_active',$a) as $player)

                    <tr>
                        <td><div class="player-wrapper"><div><span class="custom-badge custom-badge-lg is-square is-{{ strtolower($player->playerPositionShort) }}">{{ $player->playerPositionShort }}</span></div><div> <div class="player-tshirt icon-18 {{ strtolower($player->short_code) }}_player mr-1"></div>{{get_player_name('firstNameFirstCharAndFullLastName', $player->first_name, $player->last_name)}}</div></div></td>
                        <td>{{ $player->short_code }}</td>
                        <td>{{ $player->week_points }}</td>
                        <td>{{ $player->month_points }}</td>
                        <td>{{ $player->total_season_points }}</td>
                    </tr>
                @endforeach
            </tbody>
        @endforeach
    </table>
</div>
