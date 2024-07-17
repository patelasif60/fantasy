<div class="data-container-area">
    <div class="player-data-container">
        <div class="auction-content-wrapper px-4 pb-4 pt-4 pt-lg-0">
            @include('manager.divisions.online_sealed_bid.tabs.details')
            <div class="player-data-wrapper">
                <div class="row gutters-md mt-3">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="position">Position</label>
                            <select class="custom-select js-select2 js-position" name="position">
                                <option value="">All</option>
                                @foreach($positions as $posKey => $position)
                                    <option value="{{ $posKey }}">{{ $position }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="club">Club</label>
                            <select class="custom-select js-select2 js-club" name="club">
                                <option value="">All</option>
                                @foreach($clubs as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row gutters-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="player-name">Player Name</label>
                            <input type="text" class="form-control js-name" name="player-name" placeholder="e.g Harry Kane">
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input js-bought_player" id="bought_player" name="bought_player">
                            <label class="custom-control-label" for="bought_player">Hide bought players</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="player-data-wrapper">
            <div class="table-responsive">
                <table class="table text-center custom-table js-table-filter-players" data-url="{{ route('manage.auction.online.sealed.bid.json.data',['division' => $division, 'team' => $team, 'name' => 'players' ]) }}"></table>
            </div>
        </div>
    </div>
</div>
