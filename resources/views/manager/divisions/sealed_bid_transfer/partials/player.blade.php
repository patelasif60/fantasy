<div class="player-position-col cursor-pointer js-replace-player @if($selectedPlayers->where('player_out',$value->player_id)->count()) d-none @endif" id="js_replace_player_{{ $value->player_id }}" data-player-id="{{ $value->player_id }}" data-amount="{{ $value->transfer_value }}" data-player-name="{{ $value->player_first_name.' '.$value->player_last_name }}" data-position="{{ $playerKey }}" data-club="{{ $value->club_id }}">
    <div class="player-wrapper auction-player-wrapper">
        <div class="player-wrapper-img @if($isGk == $playerKey) {{ strtolower($value->short_code) }}_{{ strtolower($playerKey) }} @else {{ strtolower($value->short_code) }}_player @endif">
            <div class="transfer-process">
                <span><i class="fas fa-times"></i></span>
            </div>
        </div>
        <div class="player-wrapper-body">
            @if($playerInitialCount->get($value->player_last_name,0) > 1)
            <div class="player-wrapper-title">{{get_player_name('firstNameFirstCharAndFullLastName', $value->player_first_name, $value->player_last_name)}}</div>
            @else
            <div class="player-wrapper-title">{{get_player_name('lastName', $value->player_first_name, $value->player_last_name)}}</div>
            @endif
            <div class="player-wrapper-description">
                <div class="player-wrapper-text">
                    <div class="player-fixture-sch">
                    </div>
                    @if($bidIncrementDecimalPlace)
                        <div class="player-points"><span class="points"><span class="font-weight-normal">&pound;</span>{{ number_format($value->transfer_value, $bidIncrementDecimalPlace, '.', '') }}<span class="font-weight-normal">m</span></span></div>
                    @else
                        <div class="player-points"><span class="points"><span class="font-weight-normal">&pound;</span>{{ set_if_float_number_format($value->transfer_value) }}<span class="font-weight-normal">m</span></span></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
