<div class="px-3">
    <div class="row">
        <div class="col-6">
            <div class="form-group {{ $errors->has('round') ? ' is-invalid' : '' }}">
                <label for="round">Round</label>
                <div class="row gutters-sm">
                    <select class="custom-select js-select2" id="round" name="round">
                        <option value="">All</option>
                        @foreach($auctionRounds as $roundValue)
                            <option value="{{ $roundValue->id }}">Round {{ $roundValue->number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group {{ $errors->has('position_bid') ? ' is-invalid' : '' }}">
                <label for="position_bid">Position</label>
                <div class="row gutters-sm">
                    <select class="custom-select js-select2" id="position_bid" name="position_bid">
                        <option value="">All</option>
                        @foreach($positions as $posKey => $position)
                            <option value="{{ $posKey }}" @if(isset($data['pos']) &&  $posKey ==  $data['pos']) selected  @endif>{{ $position }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group {{ $errors->has('team') ? ' is-invalid' : '' }}">
                <label for="team">Team</label>
                <div class="row gutters-sm">
                    <select class="custom-select js-select2" id="team" name="team">
                        <option value="">All</option>
                        @foreach($teams as $teamKey =>  $teamValue)
                            <option value="{{ $teamKey }}" @if($team->id == $teamKey) selected="selected" @endif>{{ $teamValue }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="club">Club</label>
                <select class="custom-select js-select2 js-bid-club" name="club_bid" id="club_bid">
                    <option value="">All</option>
                    @foreach($clubs as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- <div class="col-6">
            <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
                <label for="status">Status</label>
                <div class="row gutters-sm">
                    <select class="custom-select js-select2" id="status" name="status">
                        <option value="">Any</option>
                        @foreach($statusEnums as $statusKey =>  $status)
                            <option value="{{ $statusKey }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> -->
    </div>
</div>



<div class="mt-3 mb-5">
    <div class="table-responsive">
        <table class="table text-center custom-table js-table-filter-bids" data-url="{{ route('manage.auction.online.sealed.bid.json.data',['division' => $division, 'team' => $team, 'name' => 'bids' ]) }}"></table>
    </div>
</div>
