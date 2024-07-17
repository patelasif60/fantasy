@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1 text-white">
                        <div class="col-12">

                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary mb-4" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="auction-tab" data-toggle="pill" href="#auction" role="tab" aria-controls="auction" aria-selected="true">Auction</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="false">Teams</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="player-tab" data-toggle="pill" href="#player" role="tab" aria-controls="player" aria-selected="false">Players</a>
                                </li>
                            </ul>

                             <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="auction" role="tabpanel" aria-labelledby="auction-tab">

                                    <ul class="custom-list-group list-group-white mb-4">
                                        <li>
                                            <div class="list-element">
                                                <span>Nominated player</span>
                                                <span>-</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="list-element">
                                                <span>Nominated by</span>
                                                <span>-</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="list-element">
                                                <span>Opening bid</span>
                                                <span>-</span>
                                            </div>
                                        </li>
                                    </ul>

                                    <p class="mt-5">It is Ben Grout’s turn to nominate a player.
                                    Once they have made their nomination, the
                                    player details will appear above.</p>
                                </div>

                                <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">Teams</div>
                                <div class="tab-pane fade" id="player" role="tabpanel" aria-labelledby="player-tab">Players</div>
                                <div class="tab-pane fade" id="bid" role="tabpanel" aria-labelledby="bid-tab">Bids</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
