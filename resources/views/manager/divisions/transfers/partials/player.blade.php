 @foreach($teamPlayers as $playerKey => $playerValue)
        <div class="player-position-grid gutters-tiny has-player">
            <div class="position-wrapper">
                <div class="position-action-area">
                    <div>
                        <span class="player-position-indicator">
                            <a href="javascript:void(0);" class="js-player-positions" data-position="{{$playerKey}}">
                                 <img src="{{ asset('assets/frontend/img/auction/has-player.png')}}">
                            </a>
                        </span>
                        <span class="standing-view-player-position is-{{strtolower(player_position_short($playerKey))}} position-relative">{{player_position_short($playerKey)}}</span>
                    </div>
                </div>
            </div>
            @foreach($dbDataArray as $playerDatakey=>$playerDataVal)
                @if($playerDataVal->position == player_position_short($playerKey))
                        <div class="player-position-col cursor-pointer playerRadio js-player-radio" data-bought-val="{{$playerDataVal->transferValue ? $playerDataVal->transferValue : '0.00'}}" data-url="{{ route('manage.division.transfer.add_players', ['division' => $division, 'team' => $team]) }}" data-position="{{player_position_short($playerKey)}}" data-team-id="{{$playerDataVal->teamId}}" data-player-id="{{$playerDataVal->playerId}}"   id="playerRadio_{{$playerDataVal->playerId}}" name="playerRadio" data-value="{{$playerDataVal->plyerModelName}}" data-club-id="{{$playerDataVal->clubId}}">
                            <div class="player-wrapper auction-player-wrapper">
                                <div class="player-wrapper-img @if(strtolower($playerDataVal->position) == 'gk'){{  strtolower($playerDataVal->shortCode) }}_{{ strtolower($playerDataVal->position) }} @else {{  strtolower($playerDataVal->shortCode) }}_player @endif">
                                    <a href="javascript:void(0);">
                                        <div class="transfer-process">
                                            <span><i class="fas fa-times" ></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="player-wrapper-body">
                                    <div class="badge-area">
                                        <div class="custom-badge is-{{strtolower($playerDataVal->position)}}">{{$playerDataVal->position}}</div>
                                    </div>
                                    <div class="player-wrapper-title">{{$playerDataVal->playerName}}</div>
                                    <div class="player-wrapper-description">
                                        <div class="player-wrapper-text">
                                            <div class="player-fixture-sch">
                                                <span class="schedule-day">{{$playerDataVal->shortCode}}</span>
                                            </div>
                                            <div class="player-points"><span class="points">£{{$playerDataVal->transferValue?$playerDataVal->transferValue:'0.00'}}</span>m</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            @endforeach
        </div>
@endforeach