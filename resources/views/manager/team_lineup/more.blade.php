@extends('layouts.manager')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('page-scripts')
<script type="text/javascript" src="{{ asset('js/manager/more/players.js') }}"></script>
<script>

    $(document).ready(function() {
        $('.js-select2').select2();

        $('body').on('change', '.js-filterByCompetition', function(){
            window.location = $(this).val();
        });

    });
</script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="{{ route('manage.division.info', ['division' => $division]) }}"><span><i class="fas fa-chevron-left"></i></span> &nbsp;&nbsp;Back</a>
                    </li>
                    <li>{{$division->name}}</li>
                    <li>
                        @can('ownLeagues', $division)
                            <a href="{{ route('manage.division.settings',['division' => $division ]) }}"> Settings &nbsp;&nbsp;<span><i class="fas fa-chevron-right"></i></span></a>
                        @endcan
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@section('content')

@php
    $positions = ['gk', 'fb', 'cb', 'df', 'dm', 'mf', 'st'];
@endphp

<div class="row align-items-center justify-content-center">
    <div class="col-12">
        <div class="container-wrapper">
            <div class="container-body text-white">
                <div class="row">
                    <div class="col-12 text-white">
                        <form action="#" class="js-player-filter-form" method="POST">
                            <div class="block">
                                <div class="block-content block-content-full">
                                    <div class="form-group row">
                                        <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-xl-4">
                                            <label for="filter-club">Competition:</label>

                                                @php

                                                    $plSelected = '';
                                                    $faSelected = '';
                                                
                                                    if($selected == 'pl')
                                                        $plSelected = 'selected="selected"';
                                                    else
                                                        $faSelected = 'selected="selected"';

                                                @endphp

                                            <select name="club" id="filter-by-competition" class="js-filterByCompetition form-control js-select2">
                                                <option value="{{ route('manage.team.lineup.more', ['division' => $division, 'team' => $team, 'competition' => 'pl']) }}" {{$plSelected}}>Premier League</option>
                                                <option value="{{ route('manage.team.lineup.more', ['division' => $division, 'team' => $team, 'competition' => 'fa']) }}" {{$faSelected}}>FA Cup</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table custom-table table-hover m-0 fixed-column">
                                <thead class="thead-dark">
                                    {{-- <tr>
                                        <th colspan="6">STARTING LINE-UP</th>
                                    </tr> --}}
                                    <tr>
                                        <th>PLAYER</th>
                                        <th class="text-center">£M</th>
                                        <th class="text-center">pld</th>
                                        <th class="text-center">gls</th>
                                        <th class="text-center">ass</th>
                                        <th class="text-center">cs</th>
                                        <th class="text-center">ga</th>

                                        @if($columns['club_win'] > 0)
                                            <th class="text-center">cw</th>
                                        @endif
                                        @if($columns['yellow_card'] > 0)
                                            <th class="text-center">yc</th>
                                        @endif
                                        @if($columns['red_card'] > 0)
                                            <th class="text-center">rc</th>
                                        @endif
                                        @if($columns['own_goal'] > 0)
                                            <th class="text-center">og</th>
                                        @endif
                                        @if($columns['penalty_missed'] > 0)
                                            <th class="text-center">pm</th>
                                        @endif
                                        @if($columns['penalty_save'] > 0)
                                            <th class="text-center">ps</th>
                                        @endif
                                        @if($columns['goalkeeper_save_x5'] > 0)
                                            <th class="text-center">gs</th>
                                        @endif
                                        
                                        <th class="text-center">WK</th>
                                        <th class="text-center">TOT</th>
                                        <th class="text-center">Next fixture</th>
                                        <th class="text-center"><a href="{{route('manage.team.lineup', ['division' => $division, 'team' => $team])}}" class="text-decoration-none text-grey-light">Back</a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($positions as $position)
                                            @if(isset($playerStats[$position]))
                                                @foreach($playerStats[$position] as $key => $player)
                                                    @if($player['is_active'] == 1)
                                                        <tr>
                                                            <td class="position">
                                                                <div class="player-wrapper">
                                                                    <span class="custom-badge custom-badge-lg is-{{strtolower($player['position'])}}">{{ $player['position'] }}</span>
                                                                    <div>
                                                                        <span class="team-name link-nostyle text-capitalize">
                                                                        {{ @$player['first_name'][0] . ' ' . $player['last_name'] }} <small>{{ @$player['short_code'] }}</small></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">{{ $player['transfer_value'] }}</td>
                                                            <td class="text-center">{{ $player['pld'] }}</td>
                                                            <td class="text-center">{{ $player['gls'] }}</td>
                                                            <td class="text-center">{{ $player['ass'] }}</td>
                                                            <td class="text-center">{{ $player['cs'] }}</td>
                                                            <td class="text-center">{{ $player['ga'] }}</td>

                                                            @if($columns['club_win'] > 0)
                                                                <td class="text-center">{{ $player['cw'] }}</td>
                                                            @endif
                                                            @if($columns['yellow_card'] > 0)
                                                                <td class="text-center">{{ $player['yc'] }}</td>
                                                            @endif
                                                            @if($columns['red_card'] > 0)
                                                                <td class="text-center">{{ $player['rc'] }}</td>
                                                            @endif
                                                            @if($columns['own_goal'] > 0)
                                                                <td class="text-center">{{ $player['og'] }}</td>
                                                            @endif
                                                            @if($columns['penalty_missed'] > 0)
                                                                <td class="text-center">{{ $player['pm'] }}</td>
                                                            @endif
                                                            @if($columns['penalty_save'] > 0)
                                                                <td class="text-center">{{ $player['ps'] }}</td>
                                                            @endif
                                                            @if($columns['goalkeeper_save_x5'] > 0)
                                                                <td class="text-center">{{ $player['gs'] }}</td>
                                                            @endif

                                                            <td class="text-center">{{ $player['week_points'] }}</td>
                                                            <td class="text-center">{{ $player['total'] }}</td>
                                                            <td class="text-center">
                                                                @if(isset($player['nextFixture']['short_code']))
                                                                    <a href="javascript:void(0);" class="team-name link-nostyle">
                                                                        {{@$player['nextFixture']['short_code']}} ({{ @strtolower($player['nextFixture']['type']) }})
                                                                    </a>
                                                                    <a href="javascript:void(0);" class="player-name link-nostyle small">
                                                                        {{@$player['nextFixture']['str_date']}} {{@$player['nextFixture']['time']}}
                                                                    </a>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if(isset($player['nextFixture']['short_code']))
                                                                    @if(@$player['nextFixture']['in_lineup'] == 'in')
                                                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                                                    @else 
                                                                        <span class="text-dark"><i class="fas fa-times"></i></span>
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                </tbody>

                                <thead class="thead-dark">
                                    <tr>
                                        <th>PLAYER</th>
                                        <th class="text-center">£M</th>
                                        <th class="text-center">pld</th>
                                        <th class="text-center">gls</th>
                                        <th class="text-center">ass</th>
                                        <th class="text-center">cs</th>
                                        <th class="text-center">ga</th>

                                        @if($columns['club_win'] > 0)
                                            <th class="text-center">cw</th>
                                        @endif
                                        @if($columns['yellow_card'] > 0)
                                            <th class="text-center">yc</th>
                                        @endif
                                        @if($columns['red_card'] > 0)
                                            <th class="text-center">rc</th>
                                        @endif
                                        @if($columns['own_goal'] > 0)
                                            <th class="text-center">og</th>
                                        @endif
                                        @if($columns['penalty_missed'] > 0)
                                            <th class="text-center">pm</th>
                                        @endif
                                        @if($columns['penalty_save'] > 0)
                                            <th class="text-center">ps</th>
                                        @endif
                                        @if($columns['goalkeeper_save_x5'] > 0)
                                            <th class="text-center">gs</th>
                                        @endif

                                        <th class="text-center">WK</th>
                                        <th class="text-center">TOT</th>
                                        <th class="text-center">Next fixture</th>
                                        <th class="text-center"><a href="{{route('manage.team.lineup', ['division' => $division, 'team' => $team])}}" class="text-decoration-none text-grey-light">Back</a></th>
                                    </tr>
                                </thead>

                                <tbody>

                                        @foreach($positions as $position)
                                            @if(isset($playerStats[$position]))
                                                @foreach($playerStats[$position] as $key => $player)
                                                    @if($player['is_active'] != 1)
                                                        <tr>
                                                            <td class="position">
                                                                <div class="player-wrapper">
                                                                    <span class="custom-badge custom-badge-lg is-{{strtolower($player['position'])}}">{{ $player['position'] }}</span>
                                                                    <div>
                                                                        <span class="team-name link-nostyle text-capitalize">
                                                                        {{ @$player['first_name'][0] . ' ' . $player['last_name'] }} <small>{{ @$player['short_code'] }}</small></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">{{ $player['transfer_value'] }}</td>
                                                            <td class="text-center">{{ $player['pld'] }}</td>
                                                            <td class="text-center">{{ $player['gls'] }}</td>
                                                            <td class="text-center">{{ $player['ass'] }}</td>
                                                            <td class="text-center">{{ $player['cs'] }}</td>
                                                            <td class="text-center">{{ $player['ga'] }}</td>

                                                            @if($columns['club_win'] > 0)
                                                                <td class="text-center">{{ $player['cw'] }}</td>
                                                            @endif
                                                            @if($columns['yellow_card'] > 0)
                                                                <td class="text-center">{{ $player['yc'] }}</td>
                                                            @endif
                                                            @if($columns['red_card'] > 0)
                                                                <td class="text-center">{{ $player['rc'] }}</td>
                                                            @endif
                                                            @if($columns['own_goal'] > 0)
                                                                <td class="text-center">{{ $player['og'] }}</td>
                                                            @endif
                                                            @if($columns['penalty_missed'] > 0)
                                                                <td class="text-center">{{ $player['pm'] }}</td>
                                                            @endif
                                                            @if($columns['penalty_save'] > 0)
                                                                <td class="text-center">{{ $player['ps'] }}</td>
                                                            @endif
                                                            @if($columns['goalkeeper_save_x5'] > 0)
                                                                <td class="text-center">{{ $player['gs'] }}</td>
                                                            @endif

                                                            <td class="text-center">{{ $player['week_points'] }}</td>
                                                            <td class="text-center">{{ $player['total'] }}</td>
                                                            <td class="text-center">
                                                                @if(isset($player['nextFixture']['short_code']))
                                                                <a href="javascript:void(0);" class="team-name link-nostyle">
                                                                    {{@$player['nextFixture']['short_code']}} ({{ @strtolower($player['nextFixture']['type']) }})
                                                                </a>
                                                                <a href="javascript:void(0);" class="player-name link-nostyle small">
                                                                    {{@$player['nextFixture']['str_date']}} {{@$player['nextFixture']['time']}}
                                                                </a>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if(isset($player['nextFixture']['short_code']))
                                                                    @if(@$player['nextFixture']['in_lineup'] == 'in')
                                                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                                                    @else 
                                                                        <span class="text-dark"><i class="fas fa-times"></i></span>
                                                                    @endif
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection