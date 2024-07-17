<form class="js-fixtures-{{strtolower($lineupType)}}-lineup-form edit" id="js-fixtures-{{strtolower($lineupType)}}-lineup-form" action="{{ route('admin.fixtures.lineup.update',['fixture'=> $fixture->id]) }}" method="post">
    {{method_field('PUT')}}
    {{ csrf_field() }}
    @php ($homeLineup = Arr::get($lineups,"$lineupType.home",null))
    @php ($awayLineup = Arr::get($lineups,"$lineupType.away",null))
    <div class="block-content block-content-full">
        <input type="hidden" class="form-control" id="lineup_type" name="lineup_type" value="{{strtoupper($lineupType)}}" />
        <div class="row">
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <h4>Home</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="filter-home-formation" class="required">Formation</label>

                            <select name="formation[{{ $fixture->home_club_id }}]" id="home_formation_id" class="form-control js-select2 lineup-container {{strtolower($lineupType)}}-home-container" activeLineup="{{strtolower($lineupType)}}-home-container">
                                <option value="">Select Formation</option>
                                        @foreach($formations as $id => $formation)
                                            <option value="{{ $id }}"  @if(Arr::has($homeLineup,'formation_id')) @if($id == $homeLineup->formation_id) selected ="selected" @endif @endif >{{ $formation }}</option>
                                        @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                @for ($i = 0; $i <= 17; $i++)
                    @if($i == 11)
                        <div class="row">
                            <div class="col-xl-6">
                            <h4>Bench</h4>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                    <select name="player[{{ $fixture->home_club_id }}][]{{$i}}" id="home_{{$i}}" class="js-select2 form-control @if($i<=10) default else bench lineup-container {{strtolower($lineupType)}}-home-container @endif players" activeLineup="@if($i<=10){{strtolower($lineupType)}}-home-container @endif">
                                        <option value="">Select a Player</option>
                                        @foreach($clubPlayers[$fixture->home_club_id] as $id => $player)
                                            <option value="{{ $id }}|{{ $player['position'] }}" @if(Arr::has($homeLineup,'formation_id')) @if(isset($homeLineup['lineupPlayer'][$i]) && $homeLineup['lineupPlayer'][$i]->player_id == $id) selected = "selected" @endif @endif>{{ $player['name'] }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="col-xl-6">
               <div class="row">
                   <div class="col-xl-12">
                       <h4>Away</h4>
                   </div>
               </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="filter-away-formation" class="required">Formation</label>
                            <select name="formation[{{ $fixture->away_club_id }}]" id="away_formation_id" class="form-control js-select2 lineup-container {{strtolower($lineupType)}}-away-container" activeLineup="{{strtolower($lineupType)}}-away-container">
                                <option value="">Select Formation</option>
                                    @foreach($formations as $id => $formation)
                                    <option value="{{ $id }}" @if(Arr::has($awayLineup,'formation_id')) @if($id == $awayLineup->formation_id ) selected ="selected" @endif @endif>{{ $formation }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @for ($i = 0; $i <= 17; $i++)
                    @if($i == 11)
                        <div class="row">
                            <div class="col-xl-6">
                            <h4>Bench</h4>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <select name="player[{{ $fixture->away_club_id }}][]{{$i}}" id="away_{{$i}}" class="js-select2 form-control @if($i<=10) default else bench lineup-container {{strtolower($lineupType)}}-away-container @endif players" activeLineup="@if($i<=10){{strtolower($lineupType)}}-away-container @endif">
                                        <option value="">Select a Player</option>
                                        @foreach($clubPlayers[$fixture->away_club_id] as $id => $player)
                                            <option value="{{ $id }}|{{ $player['position'] }}" @if(Arr::has($awayLineup,'formation_id')) @if( isset($awayLineup['lineupPlayer'][$i]) && $awayLineup['lineupPlayer'][$i]->player_id == $id)  selected = "selected" @endif @endif>{{ $player['name'] }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-hero btn-noborder btn-primary" data-form="#js-fixtures-{{strtolower($lineupType)}}-lineup-form">Save {{$lineupType}} Line-up</button>
                </div>
            </div>
        </div>
    </div>
 </form>
