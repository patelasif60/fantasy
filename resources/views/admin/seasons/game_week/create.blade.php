<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Add game week</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        <form class="js-game-week-form-create" action="{{ route('admin.gameweeks.store',['season' => $season ]) }}" method="post">
            {{ csrf_field() }}
            <div class="block-content">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('number') ? ' is-invalid' : '' }}">
                            <label for="number" class="required">Game week:</label>
                            <input type="text" class="form-control" id="number" name="number" value="{{ old('number') }}" placeholder="Game week">
                            @if ($errors->has('number'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('is_valid_cup_round') ? ' is-invalid' : '' }}">
                            <br>
                            <label class="css-control css-control-primary css-checkbox">
                                <input type="checkbox" class="css-control-input" value="1" name="is_valid_cup_round" @if(old('is_valid_cup_round') == 1) checked @endif>
                                <span class="css-control-indicator"></span> Is a valid cup round ?
                            </label>
                            @if ($errors->has('is_valid_cup_round'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('is_valid_cup_round') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group {{ $errors->has('start') ? ' is-invalid' : '' }}">
                            <label for="start" class="required">Start date:</label>
                            <input type="text" class="form-control js-datepicker"
                            id="start"
                            name="start"
                            value="{{ old('start') }}"
                            placeholder="Start date"
                            data-date-format="{{config('fantasy.datepicker.format')}}"
                            data-week-start="1"
                            data-autoclose="true"
                            data-today-highlight="true"
                            autocomplete="off">
                            @if ($errors->has('start'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('start') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group {{ $errors->has('end') ? ' is-invalid' : '' }}">
                            <label for="end" class="required">End date:</label>
                            <input type="text" class="form-control js-datepicker"
                            id="end"
                            name="end"
                            value="{{ old('end') }}"
                            placeholder="End date"
                            data-date-format="{{config('fantasy.datepicker.format')}}"
                            data-week-start="1"
                            data-autoclose="true"
                            data-today-highlight="true"
                            autocomplete="off">
                            @if ($errors->has('end'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('end') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('notes') ? ' is-invalid' : '' }}">
                            <label for="notes">Notes:</label>
                            <textarea class="form-control" id="notes" name="notes" placeholder="Notes">{{ old('notes') }}</textarea>
                            @if ($errors->has('notes'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('notes') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        &nbsp;
                    </div>
                </div>
                <h5 class="mb-0 mt-10">European competitions</h5>
                <hr>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('champions_league') ? ' is-invalid' : '' }}">
                            <label for="champions_league" >Champions league:</label>
                            <select class="form-control js-select2" data-width="100%" id="champions_league" name="champions_league">
                                <option value="">Please select</option>
                                @foreach($phaseChampionsLeague as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('champions_league'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('champions_league') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('europa_league') ? ' is-invalid' : '' }}">
                            <label for="europa_league" >Europa league:</label>
                            <select class="form-control js-select2" data-width="100%" id="europa_league" name="europa_league">
                                <option value="">Please select</option>
                                @foreach($phaseEuropaLeague as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('europa_league'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('europa_league') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <h5 class="mb-0 mt-10">League series (head to head)</h5>
                <hr>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('league_series_16') ? ' is-invalid' : '' }}">
                            <label for="league_series_16" >15 and 16 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="league_series_16" name="league_series[16]">
                                <option value="">Please select</option>
                                @foreach($phaseLeagueSeries[16] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('league_series_16'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('league_series_16') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('league_series_14') ? ' is-invalid' : '' }}">
                            <label for="league_series_14" >13 and 14 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="league_series_14" name="league_series[14]">
                                <option value="">Please select</option>
                                @foreach($phaseLeagueSeries[14] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('league_series_14'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('league_series_14') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('league_series_12') ? ' is-invalid' : '' }}">
                            <label for="league_series_12" >11 and 12 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="league_series_12" name="league_series[12]">
                                <option value="">Please select</option>
                                @foreach($phaseLeagueSeries[12] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('league_series_12'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('league_series_12') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('league_series_10') ? ' is-invalid' : '' }}">
                            <label for="league_series_10" >9 and 10 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="league_series_10" name="league_series[10]">
                                <option value="">Please select</option>
                                @foreach($phaseLeagueSeries[10] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('league_series_10'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('league_series_10') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('league_series_8') ? ' is-invalid' : '' }}">
                            <label for="league_series_8" >7 and 8 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="league_series_8" name="league_series[8]">
                                <option value="">Please select</option>
                                @foreach($phaseLeagueSeries[8] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('league_series_8'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('league_series_8') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('league_series_6') ? ' is-invalid' : '' }}">
                            <label for="league_series_6" >5 and 6 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="league_series_6" name="league_series[6]">
                                <option value="">Please select</option>
                                @foreach($phaseLeagueSeries[6] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('league_series_6'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('league_series_6') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <h5 class="mb-0 mt-10">Pro Cup (FL Cup)</h5>
                <hr>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('procup_16') ? ' is-invalid' : '' }}">
                            <label for="procup_16" >16 and 14 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="procup_16" name="procup[16]">
                                <option value="">Please select</option>
                                @foreach($phaseProCup[16] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('procup_16'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('procup_16') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('procup_13') ? ' is-invalid' : '' }}">
                            <label for="procup_13" >13 and 11 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="procup_13" name="procup[13]">
                                <option value="">Please select</option>
                                @foreach($phaseProCup[13] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('procup_13'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('procup_13') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('procup_10') ? ' is-invalid' : '' }}">
                            <label for="procup_10" >10 and 8 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="procup_10" name="procup[10]">
                                <option value="">Please select</option>
                                @foreach($phaseProCup[10] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('procup_10'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('procup_10') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group{{ $errors->has('procup_7') ? ' is-invalid' : '' }}">
                            <label for="procup_7" >7 and 5 team leagues:</label>
                            <select class="form-control js-select2" data-width="100%" id="procup_7" name="procup[7]">
                                <option value="">Please select</option>
                                @foreach($phaseProCup[7] as $league)
                                    <option value="{{ $league }}">{{ $league }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('procup_7'))
                                <div class="invalid-feedback animated fadeInDown">
                                    <strong>{{ $errors->first('procup_7') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-hero btn-noborder btn-primary">Save</button>
                <a href="#" class="btn btn-hero btn-noborder btn-alt-secondary" data-dismiss="modal">Close</a>
            </div>
        </form>
    </div>
</div>
