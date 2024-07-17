<div class="close-player-data-container">
    <span><a href="javascript:void(0);" data-dismiss="modal">
        <i class="fas fa-times-circle"></i>
    </a></span>
</div>
<div class="player-banner-wrapper">
    <div class="player-banner-img">
        <div class="player-banner-watermark">
            <img src="/assets/frontend/img/background/player-banner-bg.svg" alt="" class="player-banner-watermark-logo">
        </div>
        <img src="{{$playerDetails['image']}}" alt="" class="player-crest">
    </div>
    <div class="player-banner-body">
        @if(isset($playerDetails['status']))
        <div class="player-wrapper-status">
            <span>
                <img src="{{$playerDetails['status']['image']}}" alt="" class="lazyload status-img">
            </span>
            @if($playerDetails['status']['end_date'] != null) 
                until {{$playerDetails['status']['end_date']}}
            @endif
        </div>
        @endif
        <div class="link-nostyle squad-modal-stepper">
            <div class="squad-modal-content">
                <div class="squad-modal-label">
                    <div class="badge-area">
                        <div class="custom-badge custom-badge-xl is-square is-cb">{{$playerDetails['position']}}</div>
                    </div>
                </div>
                <div class="squad-modal-body">
                    <div class="squad-modal-title text-white">
                        {{$playerDetails['first_name'] . ' ' . $playerDetails['last_name']}}
                    </div>
                    <div class="squad-modal-text text-white">{{$playerDetails['club']}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="pills-matches-tab" data-toggle="pill" href="#pills-matches" role="tab" aria-controls="pills-matches" aria-selected="true">Matches</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-season-tab" data-toggle="pill" href="#pills-season" role="tab" aria-controls="pills-season" aria-selected="false">Season</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-fa_cup-tab" data-toggle="pill" href="#pills-fa_cup" role="tab" aria-controls="pills-fa_cup" aria-selected="false">FA Cup</a>
    </li>
    @if(count($historyStats)>0)
    <li class="nav-item">
        <a class="nav-link" id="pills-history-tab" data-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history" aria-selected="false">History</a>
    </li>
    @endif
</ul>
<div class="tab-content mt-1" id="pills-tabContent">

    <div class="tab-pane fade show active" id="pills-matches" role="tabpanel" aria-labelledby="pills-matches-tab">

        <div class="table-responsive">
            <table class="table text-center custom-table mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>DATE</th>
                        <th>OPP</th>
                        <th>RES</th>
                        <th>STATS</th>
                        <th>POINTS</th>
                        <th>TEAM</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($stats['game_stats']['history']))
                        @foreach($stats['game_stats']['history'] as $history)
                            <tr>
                                <td>{{ $history['date'] }}</td>
                                <td>
                                    @if($history['competition'] == 'FA Cup')<i class="far fa-trophy"></i> @endif
                                    {{ $history['opp'] }}
                                </td>
                                <td>
                                    @if(isset($history['res']) && trim($history['res']) != 'NA')
                                        {{ $history['res'] }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($history['appearance']))
                                        @if($history['appearance'] == 'NA')
                                            @php
                                                $fdate = \Carbon\Carbon::parse($history['date_time']);
                                                $now = \Carbon\Carbon::now();

                                                if($fdate->lt($now)) {
                                                    echo $history['appearance'];
                                                }
                                            @endphp
                                        @else
                                            <div class="d-flex justify-content-center align-items-center">
                                                @if(@$history['appearance'])
                                                    {{ @$history['appearance'] }}&nbsp;
                                                @endif

                                                @if(@$history['is_sub'] == 'in')
                                                    <span class="text-primary font-weight-bold">
                                                        <i class="fas fa-arrow-right"></i>&nbsp;
                                                    </span>
                                                @endif

                                                @if(@$history['is_sub'] == 'out')
                                                    <span class="text-danger font-weight-bold">
                                                        <i class="fas fa-arrow-left"></i>&nbsp;
                                                    </span>
                                                @endif

                                                @if(@$history['goal'] > 0)
                                                    @for ($i = 0; $i < @$history['goal']; $i++)
                                                        <span class="custom-badge custom-badge-primary is-circle">G</span>&nbsp;
                                                    @endfor
                                                @endif

                                                @if(@$history['assist'] > 0)
                                                    <span v-for="assist in history.assist" class="custom-badge custom-badge-secondary is-circle">A</span>
                                                @endif

                                                @if(@$history['red_card'] > 0)
                                                    <span class="has-card">
                                                        <img src="/assets/frontend/img/cta/icon-red-card.svg" draggable="false">&nbsp;
                                                    </span>
                                                @endif

                                                @if(@$history['yellow_card'] > 0)
                                                    <span class="has-card">
                                                        <img src="/assets/frontend/img/cta/icon-yellow-card.svg" draggable="false">&nbsp;
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if(isset($history['total']))
                                        @if(trim($history['total']) != 'NA')
                                            {{@$history['total']}}
                                        @endif
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if($history['player_is'] == 'in_lineup')
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                    @elseif ($history['player_is'] == 'substitute')
                                        <span class="text-dark"><i class="fas fa-times"></i></span>
                                    @elseif ($history['player_is'] == 'not_in_team')
                                        <span class="text-dark"><i class="fas fa-minus"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">No Records Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="pills-season" role="tabpanel" aria-labelledby="pills-season-tab">

        <div class="table-responsive">
            <table class="table text-center custom-table mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>PLD</th>
                        <th><div class="d-flex justify-content-center align-items-center"> GLS </div> </th>
                        <th><div class="d-flex justify-content-center align-items-center">ASS </div> </th>
                        <th>CS</th>
                        <th>GA</th>
                        <th>TOT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-dark">Home</td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.pld',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.gls',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.asst',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.cs',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.ga',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.total',0) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-dark">Away</td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.away.pld',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.away.gls',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.away.asst',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.away.cs',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.away.ga',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.away.total',0) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                            <td>
                                {{ Arr::get($stats, 'game_stats.premier_league.home.pld',0) + Arr::get($stats, 'game_stats.premier_league.away.pld',0) }}
                            </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.gls',0) + Arr::get($stats, 'game_stats.premier_league.away.gls',0) }}
                        </td>
                        <td>
                            {{ Arr::get($stats, 'game_stats.premier_league.home.asst',0) + Arr::get($stats, 'game_stats.premier_league.away.asst',0) }} 
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.cs',0) + Arr::get($stats, 'game_stats.premier_league.away.cs',0) }} 
                        </td>
                        <td>
                            {{ Arr::get($stats, 'game_stats.premier_league.home.ga',0) + Arr::get($stats, 'game_stats.premier_league.away.ga',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.premier_league.home.total',0) + Arr::get($stats, 'game_stats.premier_league.away.total',0) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="pills-fa_cup" role="tabpanel" aria-labelledby="pills-fa_cup-tab">

        <div class="table-responsive">
            <table class="table text-center custom-table mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>PLD</th>
                        <th><div class="d-flex justify-content-center align-items-center"> GLS </div> </th>
                        <th><div class="d-flex justify-content-center align-items-center">ASS </div> </th>
                        <th>CS</th>
                        <th>GA</th>
                        <th>TOT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-dark">Home</td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.pld',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.goals',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.assist',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.cs',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.ga',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.total',0) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-dark">Away</td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.away.pld',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.away.goals',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.away.assist',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.away.cs',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.away.ga',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.away.total',0) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                            <td>
                                {{ Arr::get($stats, 'game_stats.fa_cup.home.pld',0) + Arr::get($stats, 'game_stats.fa_cup.away.pld',0) }}
                            </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.goals',0) + Arr::get($stats, 'game_stats.fa_cup.away.goals',0) }}
                        </td>
                        <td>
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.assist',0) + Arr::get($stats, 'game_stats.fa_cup.away.assist',0) }} 
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.cs',0) + Arr::get($stats, 'game_stats.fa_cup.away.cs',0) }} 
                        </td>
                        <td>
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.ga',0) + Arr::get($stats, 'game_stats.fa_cup.away.ga',0) }}
                        </td>
                        <td> 
                            {{ Arr::get($stats, 'game_stats.fa_cup.home.total',0) + Arr::get($stats, 'game_stats.fa_cup.away.total',0) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @if(count($historyStats)>0)
    <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">

        <div class="table-responsive">
            <table class="table text-center custom-table mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Season</th>
                        <th>PLD</th>
                        <th><div class="d-flex justify-content-center align-items-center"> GLS </div> </th>
                        <th><div class="d-flex justify-content-center align-items-center">ASS </div> </th>
                        <th>CS</th>
                        <th>GA</th>
                        <th>TOT</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach($historyData as $history)
                    <tr>
                        <td class="text-dark">{{$history['name']}}</td>
                        <td> 
                            {{ $history['played'] }}
                        </td>
                        <td> 
                            {{ $history['goal']}}
                        </td>
                        <td> 
                            {{ $history['assist'] }}
                        </td>
                        <td> 
                            {{$history['clean_sheet']}}
                        </td>
                        <td> 
                            {{ $history['goal_conceded']}}
                        </td>
                        <td> 
                            {{ $history['total']}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    
    
</div>