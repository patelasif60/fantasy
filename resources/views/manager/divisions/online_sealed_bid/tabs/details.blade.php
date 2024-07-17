<div class="d-flex justify-content-space-between">
    <div class="auction-content d-flex">
        <div class="auction-crest mr-2">
            <img src="{{ $team->crest }}">
        </div>
        <div class="auction-body">
            <p class="font-weight-bold m-0">{{ $team->name }}</p>
            @can('ownTeam', $team)
                <p class="m-0 small"> {{ $team->squadSize + $team->squadSizeSealBid }} / {{ $team->defaultSquadSize }} players</p>
            @else
                <p class="m-0 small"> {{ $team->squadSize }} / {{ $team->defaultSquadSize }} players</p>
            @endcan
        </div>
    </div>

    <div class="remaining-budget text-right py-1 px-2">
        <h6 class="text-uppercase m-0 font-weight-bold">Budget</h6>
        <p class="m-0 amount">&pound;{{ set_if_float_number_format($team->budget) }}m</p>
    </div>
</div>

<div class="row gutters-sm justify-content-center mt-4">
    <div class="col-12">
        <a href="{{ route('manage.auction.online.sealed.bid.index',['division' => $division ]) }}" class="btn  btn-outline-primary no-shadow btn-block btnSearch">Back to Auction Summary</a>
    </div>
</div>
