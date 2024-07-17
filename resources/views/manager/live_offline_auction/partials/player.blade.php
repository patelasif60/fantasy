<a class="player-position-col js-detail-player-bid" data-bid="{{$value->transfer_value}}" data-player-id="{{$value->player_id}}" data-team="{{$value->team_id}}" data-player="{{$value->player_first_name.' '.$value->player_last_name}}" data-club="{{$value->club_name}}" data-id="{{$value->player_id}}" data-position="{{$value->position}}" data-contract="{{$value->team_player_contract_id}}">
    <div class="player-wrapper auction-player-wrapper">
        <div class="player-wrapper-img @if(strtolower($playerKey) == 'gk') {{ strtolower($value->short_code) }}_{{ strtolower($playerKey) }} @else {{ strtolower($value->short_code) }}_player @endif">
        </div>
        <div class="player-wrapper-body">
            <div class="badge-area">
                <div class="custom-badge is-{{strtolower($playerKey)}}">{{$playerKey}}</div>
            </div>
            <div class="player-wrapper-title">{{get_player_name('lastName', $value->player_first_name, $value->player_last_name)}}</div>
            <div class="player-wrapper-description">
                <div class="player-wrapper-text">
                    <div class="player-fixture-sch">
                        <span class="schedule-day">{{ $value->short_code }}</span>
                        {{-- <span class="schedule-date"> @if($value->nextFixture) {{ carbon_format_to_date_for_fixture($value->nextFixture) }} @endif </span> --}}
                    </div>
                    <div class="player-points"><span class="points"></span> &pound;{{floatval($value->transfer_value)}}m</div>
                </div>
            </div>
        </div>
    </div>
</a>
