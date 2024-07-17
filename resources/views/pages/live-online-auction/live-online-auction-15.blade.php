@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
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
                                    <a class="nav-link" id="auctioneer-tab" data-toggle="pill" href="#auctioneer" role="tab" aria-controls="auctioneer" aria-selected="false">Auctioneer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="false">Teams</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="player-tab" data-toggle="pill" href="#player" role="tab" aria-controls="player" aria-selected="false">Players</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link active" id="bid-tab" data-toggle="pill" href="#bid" role="tab" aria-controls="bid" aria-selected="true">Bids</a>
                                </li>
                            </ul>

                             <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade" id="auctioneer" role="tabpanel" aria-labelledby="auctioneer-tab">Auction</div>

                                <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">Teams</div>
                                <div class="tab-pane fade" id="player" role="tabpanel" aria-labelledby="player-tab">Players</div>
                                <div class="tab-pane fade show active" id="bid" role="tabpanel" aria-labelledby="bid-tab">

                                    <p class="text-white">
                                        As auctioneer, you are able to edit any
                                        finished bidding rounds or cancel a bid
                                        entirely. If you edit a bid, the player will be
                                        returned to the player list and the transfer fee
                                        returned to the team.
                                    </p>

                                    <div class="form-group">
                                        <label for="nominated-player">Nominated player</label>
                                        <input type="text" class="form-control" id="nominated-player" name="nominated-player" placeholder="Harry Kane (TOT) ST">
                                    </div>

                                    <div class="form-group">
                                        <label for="bidder">High bidder</label>
                                        <select class="js-bidder-select2" id="bidder">
                                            <option value="Chris Cragg">Chris Cragg (Oh Not Again)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="value">Value (£m)</label>
                                        <input type="text" class="form-control" id="value" name="value" placeholder="35">
                                    </div>

                                    <div class="row mb-2 gutters-md">
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-outline-white btn-block">Cancel bid</button>
                                        </div>
                                        <div class="col-sm-6 mt-2 mt-sm-0">
                                            <button type="submit" class="btn btn-primary btn-block">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page-scripts')
    <script>
        $(function () {
            $('.js-bidder-select2').select2();
        });
    </script>
@endpush

@push('footer-content')
    @include('partials.auth.footer')
@endpush
