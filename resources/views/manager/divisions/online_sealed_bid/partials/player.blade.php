<div class="player-position-col @if($value->isSealBid) js-player-bid-view cursor-pointer @endif " data-player="{{ get_player_name('fullName', $value->player_first_name, $value->player_last_name) }}" data-club="{{ $value->club_name }}" data-player-id="{{ $value->player_id }}" data-position="{{ $value->position }}" data-amount="{{ $value->transfer_value }}" data-id="{{ $value->seal_bid_id }}">
    <div class="player-wrapper auction-player-wrapper">
        <div class="player-wrapper-img @if($isGk == $playerKey) {{ strtolower($value->short_code) }}_{{ strtolower($playerKey) }} @else {{ strtolower($value->short_code) }}_player @endif">
            @if($value->isSealBid)
                <div class="time-indicator d-lg-none">
                    <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                </div>
            @endif
        </div>
        <div class="player-wrapper-body">
            <div class="badge-area">
                @if($value->isSealBid)
                    <div class="time-indicator d-none d-lg-inline-block">
                        <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                    </div>
                @endif
            </div>
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
