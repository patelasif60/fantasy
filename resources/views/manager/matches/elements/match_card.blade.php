@if(count($matches))
    @php 
        $oldMatchDtTime = '';
    @endphp
    @foreach($matches as $match)
        <div class="row">
            <div class="col-12">

                @if($oldMatchDtTime != str_replace([":", " "], "", $match->time . $match->date))
                <div class="fixture-scheduled-time">
                    <a href="javascript:void(0)" data-href="{{route('manage.gameWeek.fixture.stats', ['division' => $division, 'gameWeek' => $gameWeek,'fixture' => $match->id])}}" class="link-nostyle jsGetFixtureStats" class="link-nostyle jsGetFixtureStats">
                        {{$match->time}}  <span class="ml-2">{{$match->date}}</span>
                        @if($match->competition == 'FA Cup')
                            <i class="ml-1 far fa-trophy"></i>
                        @endif
                    </a>
                </div>
                @endif

                @php
                    $oldMatchDtTime = str_replace([":", " "], "", $match->time . $match->date);
                @endphp

                <ul class="fixture-detail-wrapper">
                    <li class="fixture-detail">
                        <span class="home-team-info">
                            <span class="team-img-area">
                                <span class="team-img {{strtolower($match->home_team->short_code)}}_player"></span>
                            </span>
                            <span class="team-name">{{$match->home_team->short_name}}</span>
                        </span>
                        <span style="cursor: pointer;" data-href="{{route('manage.gameWeek.fixture.stats', ['division' => $division, 'gameWeek' => $gameWeek,'fixture' => $match->id])}}" class="match-score-info jsGetFixtureStats">{{$match->home_score}} - {{$match->away_score}}</span>
                        <span class="away-team-info">
                            <span class="team-name">{{$match->away_team->short_name}}</span>
                            <span class="team-img-area">
                                <span class="team-img {{strtolower($match->away_team->short_code)}}_player"></span>
                            </span>
                        </span>
                    </li>
                </ul>

                @if($match->home_score > 0 || $match->away_score > 0)

                    <div class="row team-fixture-detail">
                        <div class="col-6">
                            <ul class="fixture-detail-wrapper">
                                @if(isset($matchePlayers[$match->id]))
                                    @php $tmpPlayerId = 0; @endphp
                                    @foreach ($matchePlayers[$match->id] as $player)
                                        @if($player['player_club'] == 'Home' && $player['event_type'] == 1)
                                            @if($player['goal'] > 0)
                                                @if($tmpPlayerId != $player['player_id'].''.$player['minute'])
                                                    <li class="player-info">
                                                        <span class="player-badge-area">
                                                            <span class="player-badge player-badge-primary">G</span>
                                                        </span>
                                                        <span class="player-name">{{$player['first_name'][0] . ' ' . $player['last_name']}} ({{$player['goal_time']}})</span>
                                                    </li>
                                                    @if(isset($player['field_value']))

                                                        @php
                                                            // $assists = array_unique(array_filter(explode(',', $player['field_value'])));
                                                            $assists = $player['field_value'];
                                                            if(isset($player['minute'])) {
                                                                $minute = str_replace(':', '', $player['minute']);
                                                            }
                                                        @endphp

                                                        @foreach($assists[$minute] as $key => $assist)
                                                            @if(isset($assistPlayers[$assist]))
                                                                <li class="player-info">
                                                                    <span class="player-badge-area">
                                                                        <span class="player-badge player-badge-secondary">A</span>
                                                                    </span>
                                                                    <span class="player-name">{{@$assistPlayers[$assist]->first_name[0] . ' ' . $assistPlayers[$assist]->last_name}}
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        {{-- @foreach($assists as $key => $assist)
                                                            {{dd($assists)}}
                                                            @if(isset($assistPlayers[$assist]) && $key == $minute)
                                                                <li class="player-info">
                                                                    <span class="player-badge-area">
                                                                        <span class="player-badge player-badge-secondary">A</span>
                                                                    </span>
                                                                    <span class="player-name">{{@$assistPlayers[$assist]->first_name[0] . ' ' . $assistPlayers[$assist]->last_name}}
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        @endforeach --}}
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                        @if($player['player_club'] == 'Away' && $player['event_type'] == 11)

                                            <li class="player-info">
                                                <span class="player-badge-area">
                                                    <span class="player-badge player-badge-primary">G</span>
                                                </span>
                                                <span class="player-name">{{$player['first_name'][0] . ' ' . $player['last_name']}} o.g. ({{$player['goal_time']}})</span>
                                            </li>
                                            @if(isset($player['field_value']))

                                                @php
                                                    // $assists = array_unique(array_filter(explode(',', $player['field_value'])));
                                                    $assists = $player['field_value'];
                                                    if(isset($player['minute'])) {
                                                        $minute = str_replace(':', '', $player['minute']);
                                                    }
                                                @endphp

                                                @foreach($assists[$minute] as $key => $assist)
                                                    @if(isset($assistPlayers[$assist]))
                                                        <li class="player-info">
                                                            <span class="player-badge-area">
                                                                <span class="player-badge player-badge-secondary">A</span>
                                                            </span>
                                                            <span class="player-name">{{@$assistPlayers[$assist]->first_name[0] . ' ' . $assistPlayers[$assist]->last_name}}
                                                            </span>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- @foreach($assists as $key => $assist)
                                                    @if(isset($assistPlayers[$assist]) && $key == $minute)
                                                    <li class="player-info">
                                                        <span class="player-badge-area">
                                                            <span class="player-badge player-badge-secondary">A</span>
                                                        </span>
                                                        <span class="player-name">{{@$assistPlayers[$assist]->first_name[0] . ' ' . $assistPlayers[$assist]->last_name}}
                                                        </span>
                                                    </li>
                                                    @endif
                                                @endforeach --}}
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="fixture-detail-wrapper">

                                @if(isset($matchePlayers[$match->id]))
                                    @php $tmpPlayerId = 0; @endphp
                                    @foreach ($matchePlayers[$match->id] as $player)
                                        @if($player['player_club'] == 'Away' && $player['event_type'] == 1)
                                            @if($player['goal'] > 0)
                                                @if($tmpPlayerId != $player['player_id'].''.$player['minute'])
                                                    <li class="player-info">
                                                        <span class="player-badge-area">
                                                            <span class="player-badge player-badge-primary">G</span>
                                                        </span>
                                                        <span class="player-name">{{$player['first_name'][0] . ' ' . $player['last_name']}} ({{$player['goal_time']}})</span>
                                                    </li>
                                                    @if(isset($player['field_value']))

                                                        @php
                                                            // $assists = array_unique(array_filter(explode(',', $player['field_value'])));
                                                            $assists = $player['field_value'];
                                                            if(isset($player['minute'])) {
                                                                $minute = str_replace(':', '', $player['minute']);
                                                            }
                                                        @endphp

                                                        @foreach($assists[$minute] as $key => $assist)
                                                            @if(isset($assistPlayers[$assist]))
                                                                <li class="player-info">
                                                                    <span class="player-badge-area">
                                                                        <span class="player-badge player-badge-secondary">A</span>
                                                                    </span>
                                                                    <span class="player-name">{{@$assistPlayers[$assist]->first_name[0] . ' ' . $assistPlayers[$assist]->last_name}}
                                                                    </span>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        {{-- @foreach($assists as $key => $assist)
                                                            @if(isset($assistPlayers[$assist]) && $key == $minute)
                                                            <li class="player-info">
                                                                <span class="player-badge-area">
                                                                    <span class="player-badge player-badge-secondary">A</span>
                                                                </span>
                                                                <span class="player-name">{{@$assistPlayers[$assist]->first_name[0] . ' ' . $assistPlayers[$assist]->last_name}}
                                                                </span>
                                                            </li>
                                                            @endif
                                                        @endforeach --}}

                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                        @if($player['player_club'] == 'Home' && $player['event_type'] == 11)
                                            <li class="player-info">
                                                <span class="player-badge-area">
                                                    <span class="player-badge player-badge-primary">G</span>
                                                </span>
                                                <span class="player-name">{{$player['first_name'][0] . ' ' . $player['last_name']}} o.g. ({{$player['goal_time']}})</span>
                                            </li>
                                            @if(isset($player['field_value']))

                                                @php
                                                    // $assists = array_unique(array_filter(explode(',', $player['field_value'])));
                                                    $assists = $player['field_value'];
                                                    if(isset($player['minute'])) {
                                                        $minute = str_replace(':', '', $player['minute']);
                                                    }
                                                @endphp

                                                @foreach($assists[$minute] as $key => $assist)
                                                    @if(isset($assistPlayers[$assist]))
                                                        <li class="player-info">
                                                            <span class="player-badge-area">
                                                                <span class="player-badge player-badge-secondary">A</span>
                                                            </span>
                                                            <span class="player-name">{{@$assistPlayers[$assist]->first_name[0] . ' ' . $assistPlayers[$assist]->last_name}}
                                                            </span>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- @foreach($assists as $key => $assist)
                                                    @if(isset($assistPlayers[$assist]) && $key == $minute)
                                                    <li class="player-info">
                                                        <span class="player-badge-area">
                                                            <span class="player-badge player-badge-secondary">A</span>
                                                        </span>
                                                        <span class="player-name">{{@$assistPlayers[$assist]->first_name[0] . ' ' . $assistPlayers[$assist]->last_name}}
                                                        </span>
                                                    </li>
                                                    @endif
                                                @endforeach --}}
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                @endif

            </div>
        </div>
    @endforeach
@else
    <p class="text-center">No matches available</p>
@endif