<div>{{$fixture->time}} {{$fixture->date}}</div>

@php 
    $homeClubPlayers = [];
    $homeClubSubPlayers = [];
    if(isset($playerStats[$fixture->home_club_id])) {
        $homeClubPlayers = $playerStats[$fixture->home_club_id];
        $homeClubSubPlayers = @$playerStats[$fixture->home_club_id]['sub'];
    }

    $awayClubPlayers = [];
    if(isset($playerStats[$fixture->away_club_id])) {
        $awayClubPlayers = $playerStats[$fixture->away_club_id];
        $awayClubSubPlayers = @$playerStats[$fixture->away_club_id]['sub'];
    }

    $positions = ['gk', 'fb', 'cb', 'df', 'dm', 'mf', 'st'];
    $gaGpPositions = ['GK', 'FB', 'CB'];
@endphp

<ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="tab1-tab" data-toggle="pill" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">{{$fixture->home_team->short_name}} ({{$fixture->home_score}})</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="tab2-tab" data-toggle="pill" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">{{$fixture->away_team->short_name}} ({{$fixture->away_score}})</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="table-responsive">
            <table class="table text-center custom-table">
                <thead class="thead-dark">
                    <tr>
                        @if($isCustomisedScoring && $isYRCardIncluded)
                            <th colspan="15" class="text-left pl-2">STARTING LINE-UP</th>
                        @elseif($isCustomisedScoring && !$isYRCardIncluded)
                            <th colspan="14" class="text-left pl-2">STARTING LINE-UP</th>
                        @elseif($isYRCardIncluded)
                            <th colspan="12" class="text-left pl-2">STARTING LINE-UP</th>
                        @else
                            <th colspan="11" class="text-left pl-2">STARTING LINE-UP</th>
                        @endif
                    </tr>
                </thead>
                <thead class="thead-dark">
                    <tr>
                        <th class="text-left">Name</th>
                        <th>POS</th>
                        <th>Status</th>
                        <th>PLD</th>
                        @if($isYRCardIncluded)
                        <th>Y/R</th>
                        @endif
                        <th>GLS</th>
                        <th>ASS</th>
                        <th>CS</th>
                        <th>GA</th>
                        {{-- <th>GP</th> --}}
                        @if($isCustomisedScoring)
                            <th>OG</th>
                            <th>PM</th>
                            <th>PS</th>
                            <th>GS</th>
                        @endif
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $position)
                        @if($position != 'sub' && isset($homeClubPlayers[$position]))
                            @php $oldPlId = 0; @endphp
                            @foreach($homeClubPlayers[$position] as $player)
                                @if($oldPlId != $player->player_id)
                                    @php $oldPlId = $player->player_id; @endphp
                                @else
                                    @php continue; @endphp
                                @endif
                                <tr>
                                    <td class="text-left text-dark font-weight-bold">{{@$player->first_name[0] . ' ' . $player->last_name}}</td>
                                    <td>{{$player->position}}</td>
                                    <td>{{$player->appearance}}
                                        @if($player->is_sub == 'in')
                                            <i class="fas fa-arrow-right text-primary font-weight-bold"></i>
                                        @elseif($player->is_sub == 'out')
                                            <i class="fas fa-arrow-left text-danger font-weight-bold"></i>
                                        @endif
                                    </td>
                                    <td>{{$player->pld}}</td>
                                    @if($isYRCardIncluded)
                                    <td>{{$player->yellow_card}}/{{$player->red_card}}</td>
                                    @endif
                                    <td>{{$player->goal}}</td>
                                    <td>{{$player->assist}}</td>
                                    <td>{{$player->clean_sheet}}</td>
                                    @if($columns['goal_conceded'] != 0)
                                        <td>{{$player->goal_conceded}}</td>
                                    @endif
                                    {{-- <td>{{$player->def_app_pts}}</td> --}}
                                    @if($isCustomisedScoring)
                                        <td>{{$player->own_goal}}</td>
                                        <td>{{$player->penalty_missed}}</td>
                                        <td>{{$player->penalty_save}}</td>
                                        <td>{{$player->goalkeeper_save}}</td>
                                    @endif
                                    <td>{{$player->points}}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>

                <thead class="thead-dark">
                    <tr>
                        @if($isCustomisedScoring && $isYRCardIncluded)
                            <th colspan="15" class="text-left pl-2">SUBSTITUTES</th>
                        @elseif($isCustomisedScoring && !$isYRCardIncluded)
                            <th colspan="14" class="text-left pl-2">SUBSTITUTES</th>
                        @elseif($isYRCardIncluded)
                            <th colspan="12" class="text-left pl-2">SUBSTITUTES</th>
                        @else
                            <th colspan="11" class="text-left pl-2">SUBSTITUTES</th>
                        @endif
                    </tr>
                </thead>
                <thead class="thead-dark">
                    <tr>
                        <th class="text-left">Name</th>
                        <th>POS</th>
                        <th>Status</th>
                        <th>PLD</th>
                        @if($isYRCardIncluded)
                        <th>Y/R</th>
                        @endif
                        <th>GLS</th>
                        <th>ASS</th>
                        <th>CS</th>
                        <th>GA</th>
                        {{-- <th>GP</th> --}}
                        @if($isCustomisedScoring)
                            <th>OG</th>
                            <th>PM</th>
                            <th>PS</th>
                            <th>GS</th>
                        @endif
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $position)
                        @if(isset($homeClubSubPlayers[$position]))
                            @php $oldPlId = 0; @endphp
                            @foreach($homeClubSubPlayers[$position] as $player)
                                @if($oldPlId != $player->player_id)
                                    @php $oldPlId = $player->player_id; @endphp
                                @else
                                    @php continue; @endphp
                                @endif
                                <tr>
                                    <td class="text-left text-dark font-weight-bold">{{@$player->first_name[0] . ' ' . $player->last_name}}</td>
                                    <td>{{$player->position}}</td>
                                    <td>
                                        @if($player->appearance > 0 && $player->appearance < $minsMatchPlayed)
                                           {{$minsMatchPlayed - $player->appearance}}
                                        @else
                                            {{$player->appearance}}
                                        @endif
                                        @if($player->is_sub == 'in')
                                            <i class="ml-1 fas fa-arrow-right text-primary font-weight-bold"></i>
                                        @elseif($player->is_sub == 'out')
                                            <i class="ml-1 fas fa-arrow-left text-primary font-weight-bold"></i>
                                        @endif
                                    </td>
                                    <td>{{$player->pld}}</td>
                                    @if($isYRCardIncluded)
                                    <td>{{$player->yellow_card}}/{{$player->red_card}}</td>
                                    @endif
                                    <td>{{$player->goal}}</td>
                                    <td>{{$player->assist}}</td>
                                    <td>{{$player->clean_sheet}}</td>
                                    @if($columns['goal_conceded'] != 0)
                                        <td>{{$player->goal_conceded}}</td>
                                    @endif
                                    {{-- <td>{{$player->def_app_pts}}</td> --}}
                                    @if($isCustomisedScoring)
                                        <td>{{$player->own_goal}}</td>
                                        <td>{{$player->penalty_missed}}</td>
                                        <td>{{$player->penalty_save}}</td>
                                        <td>{{$player->goalkeeper_save}}</td>
                                    @endif
                                    <td>{{$player->points}}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        <div class="table-responsive">
            <table class="table text-center custom-table">
                <thead class="thead-dark">
                    <tr>
                        @if($isCustomisedScoring && $isYRCardIncluded)
                            <th colspan="15" class="text-left pl-2">STARTING LINE-UP</th>
                        @elseif($isCustomisedScoring && !$isYRCardIncluded)
                            <th colspan="14" class="text-left pl-2">STARTING LINE-UP</th>
                        @elseif($isYRCardIncluded)
                            <th colspan="12" class="text-left pl-2">STARTING LINE-UP</th>
                        @else
                            <th colspan="11" class="text-left pl-2">STARTING LINE-UP</th>
                        @endif
                    </tr>
                </thead>
                <thead class="thead-dark">
                    <tr>
                        <th class="text-left">Name</th>
                        <th>POS</th>
                        <th>Status</th>
                        <th>PLD</th>
                        @if($isYRCardIncluded)
                        <th>Y/R</th>
                        @endif
                        <th>GLS</th>
                        <th>ASS</th>
                        <th>CS</th>
                        <th>GA</th>
                        {{-- <th>GP</th> --}}
                        @if($isCustomisedScoring)
                            <th>OG</th>
                            <th>PM</th>
                            <th>PS</th>
                            <th>GS</th>
                        @endif
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $position)
                        @if($position != 'sub' && isset($awayClubPlayers[$position]))
                            @php $oldPlId = 0; @endphp
                            @foreach($awayClubPlayers[$position] as $player)
                                @if($oldPlId != $player->player_id)
                                    @php $oldPlId = $player->player_id; @endphp
                                @else
                                    @php continue; @endphp
                                @endif
                                <tr>
                                    <td class="text-left text-dark font-weight-bold">{{@$player->first_name[0] . ' ' . $player->last_name}}</td>
                                    <td>{{$player->position}}</td>
                                    <td>{{$player->appearance}}
                                        @if($player->is_sub == 'in')
                                            <i class="fas fa-arrow-right text-primary font-weight-bold"></i>
                                        @elseif($player->is_sub == 'out')
                                            <i class="fas fa-arrow-left text-danger font-weight-bold"></i>
                                        @endif
                                    </td>
                                    <td>{{$player->pld}}</td>
                                    @if($isYRCardIncluded)
                                    <td>{{$player->yellow_card}}/{{$player->red_card}}</td>
                                    @endif
                                    <td>{{$player->goal}}</td>
                                    <td>{{$player->assist}}</td>
                                    <td>{{$player->clean_sheet}}</td>
                                    @if($columns['goal_conceded'] != 0)
                                        <td>{{$player->goal_conceded}}</td>
                                    @endif
                                    {{-- <td>{{$player->def_app_pts}}</td> --}}
                                    @if($isCustomisedScoring)
                                        <td>{{$player->own_goal}}</td>
                                        <td>{{$player->penalty_missed}}</td>
                                        <td>{{$player->penalty_save}}</td>
                                        <td>{{$player->goalkeeper_save}}</td>
                                    @endif
                                    <td>{{$player->points}}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>

                <thead class="thead-dark">
                    <tr>
                        @if($isCustomisedScoring && $isYRCardIncluded)
                            <th colspan="15" class="text-left pl-2">SUBSTITUTES</th>
                        @elseif($isCustomisedScoring && !$isYRCardIncluded)
                            <th colspan="14" class="text-left pl-2">SUBSTITUTES</th>
                        @elseif($isYRCardIncluded)
                            <th colspan="12" class="text-left pl-2">SUBSTITUTES</th>
                        @else
                            <th colspan="11" class="text-left pl-2">SUBSTITUTES</th>
                        @endif
                    </tr>
                </thead>
                <thead class="thead-dark">
                    <tr>
                        <th class="text-left">Name</th>
                        <th>POS</th>
                        <th>Status</th>
                        <th>PLD</th>
                        @if($isYRCardIncluded)
                        <th>Y/R</th>
                        @endif
                        <th>GLS</th>
                        <th>ASS</th>
                        <th>CS</th>
                        <th>GA</th>
                        {{-- <th>GP</th> --}}
                        @if($isCustomisedScoring)
                            <th>OG</th>
                            <th>PM</th>
                            <th>PS</th>
                            <th>GS</th>
                        @endif
                        <th>Pts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $position)
                        @if(isset($awayClubSubPlayers[$position]))
                            @php $oldPlId = 0; @endphp
                            @foreach($awayClubSubPlayers[$position] as $player)
                                @if($oldPlId != $player->player_id)
                                    @php $oldPlId = $player->player_id; @endphp
                                @else
                                    @php continue; @endphp
                                @endif
                                <tr>
                                    <td class="text-left text-dark font-weight-bold">{{@$player->first_name[0] . ' ' . $player->last_name}}</td>
                                    <td>{{$player->position}}</td>
                                    <td>
                                        @if($player->appearance > 0 && $player->appearance < $minsMatchPlayed)
                                           {{$minsMatchPlayed - $player->appearance}}
                                        @else
                                            {{$player->appearance}}
                                        @endif
                                        @if($player->is_sub == 'in')
                                            <i class="ml-1 fas fa-arrow-right text-primary font-weight-bold"></i>
                                        @elseif($player->is_sub == 'out')
                                            <i class="ml-1 fas fa-arrow-left text-primary font-weight-bold"></i>
                                        @endif
                                    </td>
                                    <td>{{$player->pld}}</td>
                                    @if($isYRCardIncluded)
                                    <td>{{$player->yellow_card}}/{{$player->red_card}}</td>
                                    @endif
                                    <td>{{$player->goal}}</td>
                                    <td>{{$player->assist}}</td>
                                    <td>{{$player->clean_sheet}}</td>
                                    @if($columns['goal_conceded'] != 0)
                                        <td>{{$player->goal_conceded}}</td>
                                    @endif
                                    {{-- <td>{{$player->def_app_pts}}</td> --}}
                                    @if($isCustomisedScoring)
                                        <td>{{$player->own_goal}}</td>
                                        <td>{{$player->penalty_missed}}</td>
                                        <td>{{$player->penalty_save}}</td>
                                        <td>{{$player->goalkeeper_save}}</td>
                                    @endif
                                    <td>{{$player->points}}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>