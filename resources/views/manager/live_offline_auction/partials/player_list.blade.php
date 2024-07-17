<div class="data-container-area">
    <div class="player-data-container">
        <div class="auction-content-wrapper p-3">
            <div class="d-flex justify-content-space-between">
                <div class="auction-content d-flex">
                    <div class="auction-crest mr-2">
                        <img src="{{ $team->getCrestImageThumb()}}">
                    </div>
                    <div class="auction-body">
                        <p class="font-weight-bold m-0">{{$team->name}}</p>
                        <p class="m-0 small">{{$totalTeamPlayers}} / {{$division->getOptionValue('default_squad_size')}} players</p>
                    </div>
                </div>

                <div class="remaining-budget text-right py-1 px-2">
                    <h6 class="text-uppercase m-0 font-weight-bold">budget</h6>
                    <p class="m-0 amount">&pound;{{floatval($team->team_budget)}}m</p>
                </div>
            </div>
            <div class="row gutters-sm justify-content-center mt-4">
                    <div class="col-12">
                        <a href="{{ route('manage.auction.offline.index',['division' => $division ]) }}" class="btn btn-outline-primary no-shadow btn-block btnSearch">Back to Auction Summary</a>
                    </div>
            </div>
            <form action="#" class="player-data-wrapper" method="POST">
                <div class="row gutters-md mt-3">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="filter-position">Position:</label>
                            <select name="position" class="form-control js-select2 js-filter-position">
                                <option value="">All</option>
                                @foreach($positions as $id => $value)
                                     <option value="{{ $id }}" @if($id == 'GK') selected @endif>{{ $value }}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="filter-club">Club:</label>
                            <select name="club" class="form-control js-select2 js-filter-club">
                                <option value="">All</option>
                                @foreach($clubs as $id => $club)
                                     <option value="{{ $club->id }}">{{ $club->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>

                <div class="row gutters-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="player_name">Player Name:</label>
                            <input type="text" class="form-control js-player_name" placeholder="Player Name/Code">
                        </div>

                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input js-boughtPlayers" id="boughtPlayers" value="1">
                            <label class="custom-control-label" for="boughtPlayers">Hide bought players</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="player-data-wrapper">
            <div class="table-responsive">
                <table class="table custom-table manager-teams-list-table has-player-short-code" data-url="{{ route('manage.auction.get.players', ['division' => $division, 'team' => $team]) }}"></table>
            </div>
        </div>
    </div>
</div>

