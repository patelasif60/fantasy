@foreach($positions as $key => $posName)
@if($data->where('position',$key)->count())
        <table class="position-table" border="0">
            <tr>
                <td></td>
                <td colspan="3"><strong>{{ strtoupper(player_position_except_code($key)) }}S</strong></td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td><strong>Code</strong></td>
                <td><strong>Name</strong></td>
                <td><strong>Club</strong></td>
                <td><strong>Pts</strong></td>
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
