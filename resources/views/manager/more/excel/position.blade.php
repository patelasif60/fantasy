@foreach($positions as $key => $posName)
@if($data->where('position',$key)->count())
        <table class="position-table" border="0">
            <tr>
                <td></td>
                <td colspan="3">{{ strtoupper(player_position_except_code($key)) }}S</td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Code</td>
                <td>Name</td>
                <td>Club</td>
                <td>Pts</td>
            </tr>
            @foreach($data->where('position',$key) as $player)
            <tr>
                <td>{{ $player->short_code }}</td>
                <td>{{get_player_name('firstNameFirstCharAndFullLastName', $player->player_first_name, $player->player_last_name)}}</td>
                <td>{{ $player->club_name }}</td>
                <td>{{ $player->total }}</td>
            </tr>
            @endforeach
        </table>
    @endif
@endforeach
