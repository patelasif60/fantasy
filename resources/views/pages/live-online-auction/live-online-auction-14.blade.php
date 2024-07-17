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

                                    <div class="form-group">
                                        <label for="team">Team</label>
                                        <select class="js-team-select2" id="team">
                                            <option value="All">All</option>
                                        </select>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table custom-table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <th class="text-center">£M</th>
                                                    <th class="text-center">Round</th>
                                                    <th class="text-center">PLD</th>
                                                    <th class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <span class="custom-badge custom-badge-primary is-circle">G</span>
                                                        </div>
                                                    </th>
                                                    <th class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <span class="custom-badge custom-badge-secondary is-circle">A</span>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Richard stenson</a></div>
                                                    </td>
                                                    <td class="text-center">7.50</td>
                                                    <td class="text-center">17</td>
                                                    <td class="text-center">19</td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">3</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>

                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">Kepa</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Chelsea</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Richard stenson</a></div>
                                                    </td>
                                                    <td class="text-center">1.00</td>
                                                    <td class="text-center">43</td>
                                                    <td class="text-center">20</td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">0</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="player-wrapper">
                                                            <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>
                                                            <div>
                                                                <a href="#" class="team-name link-nostyle">Allisson</a>
                                                                <br>
                                                                <a href="#" class="player-name link-nostyle small">Liverpool</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div><a href="#" class="team-name link-nostyle">Richard's Team</a></div>
                                                        <div><a href="#" class="player-name link-nostyle small">Richard stenson</a></div>
                                                    </td>
                                                    <td class="text-center">1.50</td>
                                                    <td class="text-center">4</td>
                                                    <td class="text-center">13</td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center">-2</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
            $('.js-team-select2').select2();
        });
    </script>
@endpush

@push('footer-content')
    @include('partials.auth.footer')
@endpush
