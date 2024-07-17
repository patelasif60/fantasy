@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/datatables.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
    <script type="text/javascript" src="{{ asset('js/manager/leaguereports/index.js') }}"></script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.teams.settings',['division' => $division, 'team' => $team]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li>Lineup</li>
                    <li>
                        <a href="{{ route('manage.division.settings',['division' => $division ]) }}"> Settings &nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')
    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row no-gutters">
                        <div class="col-12 is-sticky" id="lineUp-Details">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Lineup-tab" data-toggle="pill" href="#Lineup" role="tab" aria-controls="Lineup" aria-selected="true">Lineup</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Supersubs-tab" data-toggle="pill" href="#Supersubs" role="tab" aria-controls="Supersubs" aria-selected="false">Supersubs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Data-tab" data-toggle="pill" href="#Data" role="tab" aria-controls="Data" aria-selected="false">Data</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-12">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="Lineup" role="tabpanel" aria-labelledby="Lineup-tab">
                                    <div class="pitch-layout">
                                        <div class="pitch-area">
                                            <div class="pitch-image">
                                                <img class="lazyload" src="{{ asset('assets/frontend/img/default/square/default-thumb-250.png')}}" data-src="{{ asset('assets/frontend/img/pitch/pitch-1.svg') }}" alt="">
                                            </div>
                                            <div class="pitch-players-standing">
                                                <div class="standing-area">
                                                    <div class="standing-view">
                                                        
                                                        {{-- Row 1 - GK --}}
                                                        @if(isset($activePlayers['gk']))
                                                            <div class="standing-view-grid gutters-tiny">
                                                                <div class="standing-col">
                                                                    <a href="www.google.com" class="player-wrapper">
                                                                        <div class="player-wrapper-img">
                                                                            <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-6.svg')}}" alt="">
                                                                        </div>
                                                                        <div class="player-wrapper-body">
                                                                            <div class="player-wrapper-title">{{ $activePlayers['gk'][0]['player_first_name'] }}</div>
                                                                            <div class="player-wrapper-description">
                                                                                <div class="custom-badge custom-badge-lg is-square is-gk">GK</div>
                                                                                <div class="player-wrapper-text">
                                                                                    <div class="status-indicator"><span></span></div>
                                                                                    <div class="player-points"><span class="points">{{ $activePlayers['gk'][0]['total'] == "" ? 0 : $activePlayers['gk'][0]['total'] }}</span> pts</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        {{-- Row 2 - FB/CB or DF --}}
                                                        <div class="standing-view-grid gutters-tiny">
                                                            @if(isset($activePlayers['df']))
                                                                @foreach($activePlayers['df'] as $player)
                                                                    <div class="standing-col">
                                                                        <div class="player-wrapper">
                                                                            <div class="player-wrapper-img">
                                                                                <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-4.svg')}}" alt="">
                                                                            </div>
                                                                            <div class="player-wrapper-body">
                                                                                <div class="player-wrapper-title">{{ $player['player_first_name'] }}</div>
                                                                                <div class="player-wrapper-description">
                                                                                    <div class="custom-badge custom-badge-lg is-square is-{{ strtolower($player['position']) }}">{{ $player['position'] }}</div>
                                                                                    <div class="player-wrapper-text">
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                        <div class="player-points"><span class="points">{{ $player['total'] == "" ? 0 : $player['total'] }}</span> pts</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach                                                            
                                                            @endif
                                                        </div>
                                                        
                                                        {{-- Row 3 - MF or DM --}}
                                                        @if(isset($activePlayers['mf']))
                                                        <div class="standing-view-grid gutters-tiny">
                                                            @foreach($activePlayers['mf'] as $player)
                                                            <div class="standing-col">
                                                                <div class="player-wrapper">
                                                                    <div class="player-wrapper-img">
                                                                        <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt="">
                                                                    </div>
                                                                    <div class="player-wrapper-body">
                                                                        <div class="player-wrapper-title">{{ $player['player_first_name'] }}</div>
                                                                        <div class="player-wrapper-description">
                                                                            <div class="custom-badge custom-badge-lg is-square is-{{strtolower($player['curr_position'] )}}">{{ $player['curr_position'] }}</div>
                                                                            <div class="player-wrapper-text">
                                                                                <div class="status-indicator"><span></span></div>
                                                                                <div class="player-points"><span class="points">{{ $player['total'] == "" ? 0 : $player['total'] }}</span> pts</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @endif
                                                        
                                                        {{-- Row 4 - ST --}}
                                                        @if(isset($activePlayers['st']))
                                                        <div class="standing-view-grid gutters-tiny justify-content-center">
                                                            @foreach($activePlayers['st'] as $player)
                                                            <div class="standing-col">
                                                                <div class="player-wrapper">
                                                                    <div class="player-wrapper-img">
                                                                        <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-2.svg')}}" alt="">
                                                                    </div>
                                                                    <div class="player-wrapper-body">
                                                                        <div class="player-wrapper-title">{{ $player['player_first_name'] }}</div>
                                                                        <div class="player-wrapper-description">
                                                                            <div class="custom-badge custom-badge-lg is-square is-st">ST</div>
                                                                            <div class="player-wrapper-text">
                                                                                <div class="status-indicator"><span></span></div>
                                                                                <div class="player-points"><span class="points">{{ $player['total'] == "" ? 0 : $player['total'] }}</span> pts</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mr-0 player-data pr-0 pt-0">
                                            <div class="data-container-area">
                                                <div class="player-data-wrapper pt-2">
                                                    <div class="player-data-title">
                                                        Substitutes
                                                    </div>
                                                    <div class="players-list">
                                                        @if(isset($subPlayers) && count($subPlayers) > 0)
                                                            @foreach($subPlayers as $subPlayer)
                                                            <a class="player-list-info" data-togle="sidebar">
                                                                <div class="player-wrapper side-by-side">
                                                                    <div class="player-wrapper-img">
                                                                        <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-6.svg')}}" alt="">
                                                                    </div>
                                                                    <div class="player-wrapper-body">
                                                                        <div class="player-wrapper-title">{{ $subPlayer->player_first_name }}</div>
                                                                        <div class="player-wrapper-description">
                                                                            <div class="custom-badge custom-badge-lg is-square is-{{ strtolower($subPlayer->position) }}">{{ $subPlayer->position }}</div>
                                                                            <div class="player-wrapper-text">
                                                                                <div class="status-indicator"><span></span></div>
                                                                                <div class="player-points"><span class="points">{{ $subPlayer->total == "" ? 0 : $subPlayer->total }}</span> pts</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="player-data-container">
                                                    <div class="player-data-container-slim">
                                                        <div class="row no-gutters">
                                                            <div class="table-responsive">
                                                                <table class="table text-center custom-table mb-0">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th class="text-left">PLAYER</th>
                                                                            <th>TOT</th>
                                                                            <th colspan="2" class="text-left">NEXT FIXTURE</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($activePlayers as $lineupPlayerPosition)
                                                                            @if(is_array($lineupPlayerPosition))
                                                                                @foreach($lineupPlayerPosition as $player)
                                                                                    <tr>
                                                                                        <td class="text-dark">
                                                                                            <div class="player-wrapper">
                                                                                                <span class="custom-badge custom-badge-lg is-square is-{{strtolower($player['position'])}}">{{$player['position']}}</span>

                                                                                                <div class="text-left">
                                                                                                    <a href="#" class="team-name link-nostyle">{{ $player['player_first_name'] }}</a>
                                                                                                    <br>
                                                                                                    <a href="#" class="player-name link-nostyle small">{{ @$player['next_fixture']['club'] }}</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ $player['total'] == "" ? 0 : $player['total'] }}
                                                                                        </td>
                                                                                        <td>
                                                                                            @if(isset($player['next_fixture']['type']))
                                                                                            {{ @$player['next_fixture']['short_code'] }}({{ @$player['next_fixture']['type'] }})
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ @$player['next_fixture']['date'] }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <div class="table-responsive">
                                                                <table class="table text-center custom-table">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th class="text-left">SUBSTITUTE</th>
                                                                            <th>TOT</th>
                                                                            <th colspan="2" class="text-left">NEXT FIXTURE</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($subPlayers as $player)
                                                                                    <tr>
                                                                                        <td class="text-dark">
                                                                                            <div class="player-wrapper">
                                                                                                <span class="custom-badge custom-badge-lg is-square is-{{strtolower($player['position'])}}">{{$player['position']}}</span>

                                                                                                <div class="text-left">
                                                                                                    <a href="#" class="team-name link-nostyle">{{ $player['player_first_name'] }}</a>
                                                                                                    <br>
                                                                                                    <a href="#" class="player-name link-nostyle small">{{ @$player['next_fixture']['club'] }}</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ $player['total'] == "" ? 0 : $player['total'] }}
                                                                                        </td>
                                                                                        <td>
                                                                                            @if(isset($player['next_fixture']['type']))
                                                                                            {{ @$player['next_fixture']['short_code'] }}({{ @$player['next_fixture']['type'] }})
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ @$player['next_fixture']['date'] }}
                                                                                        </td>
                                                                                    </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="player-data-carousel">
                                            <div class="owl-carousel owl-theme player-carousel">
                                            @if(isset($subPlayers) && count($subPlayers) > 0)
                                                @foreach($subPlayers as $subPlayer)
                                                    <div class="item">
                                                        <a class="player-list-info" data-togle="sidebar">
                                                            <div class="player-wrapper side-by-side">
                                                                <div class="player-wrapper-img">
                                                                    <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-6.svg')}}" alt="">
                                                                </div>
                                                                <div class="player-wrapper-body">
                                                                    <div class="player-wrapper-title">{{ $subPlayer->player_first_name }}</div>
                                                                    <div class="player-wrapper-description">
                                                                        <div class="custom-badge custom-badge-lg is-square is-{{ strtolower($subPlayer->position) }}">{{ $subPlayer->position }}</div>
                                                                        <div class="player-wrapper-text">
                                                                            <div class="status-indicator"><span></span></div>
                                                                            <div class="player-points"><span class="points">{{ $subPlayer->total == "" ? 0 : $subPlayer->total }}</span> pts</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Supersubs" role="tabpanel" aria-labelledby="Supersubs-tab">

                                </div>
                                <div class="tab-pane fade" id="Data" role="tabpanel" aria-labelledby="Data-tab">

                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- <div class="col-8">
                        @if(isset($activePlayers['gk']))
                            <div class="row gutter-sm mb-25">
                                <div class="col-2 text-white border py-4">
                                    <div>{{ $activePlayers['gk'][0]['player_first_name'] }}</div>
                                    <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>
                                    <span>{{ $activePlayers['gk'][0]['total'] == "" ? 0 : $activePlayers['gk'][0]['total'] }} pts</span>
                                </div>
                            </div>
                        @endif

                        @if(isset($activePlayers['df']))
                            <div class="row gutter-sm mb-25">
                                @foreach($activePlayers['df'] as $player)
                                    <div class="col-2 text-white border py-4 mr-2">
                                        <div>{{ $player['player_first_name'] }}</div>
                                        <span class="custom-badge custom-badge-lg is-square is-df">DF</span>
                                        <span>{{ $player['total'] == "" ? 0 : $player['total'] }} pts</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row gutter-sm mb-25">
                                @if(isset($activePlayers['cb']) && isset($activePlayers['cb'][0]))
                                    <div class="col-2 text-white border py-4 mr-2">
                                        <div>{{ $activePlayers['cb'][0]['player_first_name'] }}</div>
                                        <span class="custom-badge custom-badge-lg is-square is-fb">Fb</span>
                                        <span>{{ $activePlayers['cb'][0]['total'] == "" ? 0 : $activePlayers['cb'][0]['total'] }} pts</span>
                                    </div>
                                @endif

                                @if(isset($activePlayers['cb']))
                                    @foreach($activePlayers['cb'] as $player)
                                        <div class="col-2 text-white border py-4 mr-2">
                                            <div>{{ $player['player_first_name'] }}</div>
                                            <span class="custom-badge custom-badge-lg is-square is-cb">CB</span>
                                            <span>{{ $player['total'] == "" ? 0 : $player['total'] }} pts</span>
                                        </div>
                                    @endforeach
                                @endif

                                @if(isset($activePlayers['cb']) && isset($activePlayers['cb'][1]))
                                    <div class="col-2 text-white border py-4 mr-2">
                                        <div>{{ $activePlayers['cb'][1]['player_first_name'] }}</div>
                                        <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>
                                        <span>{{ $activePlayers['cb'][1]['total'] == "" ? 0 : $activePlayers['cb'][1]['total'] }} pts</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if(isset($activePlayers['mf']))
                            <div class="row gutter-sm mb-25">
                                @foreach($activePlayers['mf'] as $player)
                                    <div class="col-2 text-white border py-4 mr-2">
                                        <div>{{ $player['player_first_name'] }}</div>
                                        <span class="custom-badge custom-badge-lg is-square is-mf">{{ $player['curr_position'] }}</span>
                                        <span>{{ $player['total'] == "" ? 0 : $player['total'] }} pts</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(isset($activePlayers['st']))
                            <div class="row gutter-sm mb-25">
                                @foreach($activePlayers['st'] as $player)
                                    <div class="col-2 text-white border py-4 mr-2">
                                        <div>{{ $player['player_first_name'] }}</div>
                                        <span class="custom-badge custom-badge-lg is-square is-st">ST</span>
                                        <span>{{ $player['total'] == "" ? 0 : $player['total'] }} pts</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-4">
                        @if(isset($activePlayers['gk']))
                            <div><span class="custom-badge custom-badge-lg is-square is-gk">GK</span> {{ $activePlayers['gk'][0]['player_first_name'] }}</div>
                            <span>{{ $activePlayers['gk'][0]['total'] == "" ? 0 : $activePlayers['gk'][0]['total'] }} pts</span>
                            <span>{{ @$activePlayers['gk'][0]['next_fixture']['short_code'] }}({{@$activePlayers['gk'][0]['next_fixture']['type']}})</span>
                            <span>{{ @$activePlayers['gk'][0]['next_fixture']['date'] }}</span>
                            <br>
                        @endif

                        @if(isset($activePlayers['df']))
                            <div class="row gutter-sm mb-25">
                                @foreach($activePlayers['df'] as $player)
                                    
                                    <div><span class="custom-badge custom-badge-lg is-square is-df">DF</span> {{ $player['player_first_name'] }}</div>
                                    <span>{{ $player['total'] == "" ? 0 : $player['total'] }} pts</span>
                                    <span>{{ @$player['next_fixture']['short_code'] }}({{@$player['next_fixture']['type']}})</span>
                                    <span>{{ @$player['next_fixture']['date'] }}</span>
                                    <br>

                                @endforeach
                            </div>
                        @else
                            <div class="row gutter-sm mb-25">
                                @if(isset($activePlayers['cb']) && isset($activePlayers['cb'][0]))

                                    <div><span class="custom-badge custom-badge-lg is-square is-fb">Fb</span> {{ $activePlayers['cb'][0]['player_first_name'] }}</div>
                                    <span>{{ $activePlayers['cb'][0]['total'] == "" ? 0 : $activePlayers['cb'][0]['total'] }} pts</span>
                                    <span>{{ @$activePlayers['cb'][0]['next_fixture']['short_code'] }}({{@$activePlayers['cb'][0]['next_fixture']['type']}})</span>
                                    <span>{{ @$activePlayers['cb'][0]['next_fixture']['date'] }}</span>
                                    <br>

                                @endif

                                @if(isset($activePlayers['cb']))
                                    @foreach($activePlayers['cb'] as $player)

                                        <div><span class="custom-badge custom-badge-lg is-square is-cb">CB</span> {{ $player['player_first_name'] }}</div>
                                        <span>{{ $player['total'] == "" ? 0 : $player['total'] }} pts</span>
                                        <span>{{ @$player['next_fixture']['short_code'] }}({{@$player['next_fixture']['type']}})</span>
                                        <span>{{ @$player['next_fixture']['date'] }}</span>
                                        <br>

                                    @endforeach
                                @endif

                                @if(isset($activePlayers['cb']) && isset($activePlayers['cb'][1]))

                                    <div><span class="custom-badge custom-badge-lg is-square is-fb">FB</span> {{ $activePlayers['cb'][1]['player_first_name'] }}</div>
                                    <span>{{ $activePlayers['cb'][1]['total'] == "" ? 0 : $activePlayers['cb'][1]['total'] }} pts</span>
                                    <span>{{ @$activePlayers['cb'][1]['next_fixture']['short_code'] }}({{@$activePlayers['cb'][1]['next_fixture']['type']}})</span>
                                    <span>{{ @$activePlayers['cb'][1]['next_fixture']['date'] }}</span>
                                    <br>

                                @endif

                            </div>
                        @endif

                        @if(isset($activePlayers['mf']))
                            <div class="row gutter-sm mb-25">
                                @foreach($activePlayers['mf'] as $player)

                                    <div><span class="custom-badge custom-badge-lg is-square is-mf">{{ $player['curr_position'] }}</span> {{ $player['player_first_name'] }}</div>
                                    <span>{{ $player['total'] == "" ? 0 : $player['total'] }} pts</span>
                                    <span>{{ @$player['next_fixture']['short_code'] }}({{@$player['next_fixture']['type']}})</span>
                                    <span>{{ @$player['next_fixture']['date'] }}</span>
                                    <br>

                                @endforeach
                            </div>
                        @endif

                        @if(isset($activePlayers['st']))
                            <div class="row gutter-sm mb-25">
                                @foreach($activePlayers['st'] as $player)

                                    <div><span class="custom-badge custom-badge-lg is-square is-st">ST</span> {{ $player['player_first_name'] }}</div>
                                    <span>{{ $player['total'] == "" ? 0 : $player['total'] }} pts</span>
                                    <span>{{ @$player['next_fixture']['short_code'] }}({{@$player['next_fixture']['type']}})</span>
                                    <span>{{ @$player['next_fixture']['date'] }}</span>
                                    <br>

                                @endforeach
                            </div>
                        @endif
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
