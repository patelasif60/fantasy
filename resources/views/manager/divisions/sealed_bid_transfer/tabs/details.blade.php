<div class="d-flex flex-column flex-lg-row justify-content-space-between">
    <div class="auction-content d-flex">
        <div class="auction-crest mr-2">
            <img src="{{ $team->crest }}">
        </div>
        <div class="auction-body">
            <p class="font-weight-bold m-0">{{ $team->name }}</p>
            <p class="m-0 small"> &pound;<span class="js-budget">0</span>m</p>
        </div>
    </div>

    <div class="remaining-budget text-right py-3 py-lg-1 px-4 mt-4 mt-lg-0 align-items-center justify-content-center js-replace-player-name d-none">
        <h6 class="text-uppercase m-0 font-weight-bold">
            <i class="fas fa-arrow-circle-left mr-2"></i>&nbsp;
            <span></span>
        </h6>
    </div>
</div>