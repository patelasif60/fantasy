@if($gameweeks->count() && $rounds > 0)
    @for ($i = 1; $i <= $rounds; $i++)
    <div class="form-group">
        <div class="js-round-with-gameweek @if($i !== 1) d-none @endif" id="js_round_with_gameweek_{{ $i }}" data-round="{{ $i }}">
            <p>Select the game weeks for Round {{ $i }}</p>
            @foreach($gameweeks as $gameweek)
                <div class="custom-control custom-checkbox mt-2 mb-2">
                    <input type="checkbox" class="custom-control-input js-rounds-gameweek" value="{{ $gameweek->id }}" name="rounds[{{ $i }}][{{ $gameweek->id }}]" id="rounds_gameweek_{{ $i }}_{{ $gameweek->id }}" @if(isset($selectedRounds[$i][$gameweek->id])) checked="checked" @endif>
                    <label class="custom-control-label" for="rounds_gameweek_{{ $i }}_{{ $gameweek->id }}">Week {{ $gameweek->number }}</label>
                </div>
            @endforeach
            <div class="row">
                <div class="col-6 col-md-6 col-lg-6">
                    <a href="javascript:void(0);" class="js-cup-back-url btn btn-danger btn-block">Back</a>
                </div>
                <div class="col-6 col-md-6 col-lg-6">
                    <a class="js-next-step-round btn btn-primary btn-block" data-round="{{ $i }}">Next</a>
                </div>
            </div>
        </div>
    </div>
    @endfor
@else
    <div class="mb-3">There is no gameweek found.</div>
    <div class="row">
        <div class="col-6 col-md-6 col-lg-6">
            <a href="javascript:void(0);" class="js-cup-back-url btn btn-danger btn-block">Back</a>
        </div>
        <div class="col-6 col-md-6 col-lg-6">
            <a href="javascript:void(0);" class="btn btn-primary btn-block disabled" role="button">Next</a>
        </div>
    </div>
@endif