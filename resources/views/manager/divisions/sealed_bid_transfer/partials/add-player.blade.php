<div class="player-position-col cursor-pointer js-new-player-edit" data-player="{{ $newValue->player_first_name }} {{ $newValue->player_last_name }}" data-club="{{ $newValue->club_name }}" data-player-id="{{ $newValue->player_in }}"  data-position="{{ $playerKey }}" data-club-id="{{ $newValue->club_id }}" data-new="{{ $newPlayerId }}" data-old="{{ $oldPlayerId }}" id="js_new_player_{{ $newPlayerId }}">
    <div class="player-wrapper auction-player-wrapper">
        <div class="player-wrapper-img @if($isGk == $playerKey) {{ strtolower($newValue->short_code) }}_{{ strtolower($playerKey) }} @else {{ strtolower($newValue->short_code) }}_player @endif">
            <div class="time-indicator d-lg-none">
                <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
            </div>
        </div>
        <div class="player-wrapper-body">
            <div class="badge-area">
                <div class="time-indicator d-none d-lg-inline-block">
                    <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                </div>
            </div>
            @if($playerInitialCount->get($newValue->player_last_name,0) > 1)
            <div class="player-wrapper-title bid-pending">{{get_player_name('firstNameFirstCharAndFullLastName', $newValue->player_first_name, $newValue->player_last_name)}}</div>
            @else
            <div class="player-wrapper-title bid-pending">{{get_player_name('lastName', $newValue->player_first_name, $newValue->player_last_name)}}</div>
            @endif
            <div class="player-wrapper-description">
                <div class="player-wrapper-text">
                    <div class="player-fixture-sch">
                    </div>
                    @if($bidIncrementDecimalPlace)
                        <div class="player-points"><span class="points"><span class="font-weight-normal">&pound;</span>{{ number_format($newValue->amount, $bidIncrementDecimalPlace, '.', '') }}<span class="font-weight-normal">m</span></span></div>
                    @else
                        <div class="player-points"><span class="points"><span class="font-weight-normal">&pound;</span>{{ set_if_float_number_format($newValue->amount) }}<span class="font-weight-normal">m</span></span></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
