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
                                    <p>It’s your turn to nominate a player. Once you
                                    have nominated a player, bidding will begin
                                    with the managers in the room.</p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="font-weight-bold">Time remaining</p>
                                        <p class="bg-primary px-2 small">60 seconds</p>
                                    </div>

                                    <div class="row gutters-md">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="position">Position</label>
                                                <select class="js-player-position-select2" id="position">
                                                    <option value="Goalkeeper">Goalkeeper</option>
                                                    <option value="Full Backs">Full Backs</option>
                                                    <option value="Center Backs">Center Backs</option>
                                                    <option value="Midfielders">Midfielders</option>
                                                    <option value="Midfielders">Strikers</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="club">Club</label>
                                                <select class="js-club-select2" id="club">
                                                    <option>All</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="player-name">Player Name</label>
                                        <input type="text" class="form-control" id="player-name" name="player-name" placeholder="e.g Harry Kane">
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table custom-table auction-table m-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-uppercase">player</th>
                                                    <th class="text-center text-uppercase">bid</th>
                                                    <th class="text-center text-uppercase">pld</th>
                                                    <th class="text-center text-uppercase">pts</th>
                                                    <th>&nbsp;</th>
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
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">17</td>
                                                    <td class="text-center">19</td>
                                                    <td class="text-center">
                                                        <div class="quota-player"><span class="text-muted text-uppercase"><strong>quota</strong> <i class="fas fa-tshirt"></i></span></div>
                                                    </td>
                                                </tr>

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
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">17</td>
                                                    <td class="text-center">19</td>
                                                    <td class="text-center">
                                                        <div class="formation-validation d-flex justify-content-center align-items-center">
                                                            <div class="text-uppercase"><strong>formation <br> validation</strong></div>
                                                            <div class="position-relative">
                                                                <span class="h5"><i class="fas fa-tshirt"></i></span>
                                                                <span class="position-absolute text-danger player-state-indicator"><i class="fas fa-exclamation-circle"></i></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

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
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">17</td>
                                                    <td class="text-center">19</td>
                                                    <td class="text-center">
                                                        <div class="text-muted text-uppercase won-by">
                                                            <span><strong>won by</strong> <br> untappedtalent</span>
                                                        </div>
                                                    </td>
                                                </tr>

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
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">17</td>
                                                    <td class="text-center">19</td>
                                                    <td class="text-center">
                                                        <div class="text-muted text-uppercase won-by">
                                                            <div class="icon-edit"><a href="" class="text-dark" data-toggle="modal" data-target="#bid-modal"><span><img src="{{ asset('assets/frontend/img/auction/bid-add.svg')}}"></span></a></div>
                                                        </div>
                                                    </td>
                                                </tr>

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
                                                    <td class="text-center">-</td>
                                                    <td class="text-center">17</td>
                                                    <td class="text-center">19</td>
                                                    <td class="text-center">
                                                        <div class="text-muted text-uppercase won-by">
                                                            <div class="icon-edit"><a href="" class="text-dark" data-toggle="modal" data-target="#edit-bid-modal"><span><img src="{{ asset('assets/frontend/img/auction/bid-edit.svg')}}"></span></a></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-4 mb-2"><button type="submit" class="btn btn-primary btn-block">Pass</button></div>
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

@push ('modals')
    <!-- Modal -->
    <div class="modal fade" id="edit-bid-modal" tabindex="-1" role="dialog" aria-labelledby="edit-bid-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="player-bid-modal-body">
                        <div class="player-bid-modal-content">
                            <div class="player-bid-modal-label">
                                <div class="custom-badge custom-badge-xl is-square is-gk">gk</div>
                            </div>
                            <div class="player-bid-modal-body">
                                <div class="player-bid-modal-title">H Lioris</div>
                                <div class="player-bid-modal-text">Tottenham</div>
                            </div>
                        </div>

                        <div class="my-3">
                            <button type="button" class="btn btn-primary btn-block">Edit bid</button>
                        </div>

                        <div class="row gutters-sm">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-tertiary btn-block">Remove bid</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="bid-modal" tabindex="-1" role="dialog" aria-labelledby="bid-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm player-bid-modal" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="player-bid-modal-body">
                        <div class="player-bid-modal-content">
                            <div class="player-bid-modal-label">
                                <div class="custom-badge custom-badge-xl is-square is-fb">FB</div>
                            </div>
                            <div class="player-bid-modal-body">
                                <div class="player-bid-modal-title">Kepa</div>
                                <div class="player-bid-modal-text">Chelsea</div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="bid-amount">Enter bid amount (&euro;m)</label>
                            <input type="text" class="form-control" id="bid-amount" placeholder="e.g 15">
                        </div>

                        <div class="row gutters-sm">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-dark btn-block" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-block">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('page-scripts')
    <script>
        $(function () {
            $('.js-player-position-select2').select2();
            $('.js-club-select2').select2();
        });
    </script>
@endpush


@push('footer-content')
    @include('partials.auth.footer')
@endpush
