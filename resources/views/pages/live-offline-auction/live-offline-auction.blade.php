@extends('layouts.auth.redesign')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
@endpush

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{ asset('/js/plugins/fitty/dist/fitty.min.js')}}"></script>
@endpush

@push('page-scripts')
    <script>
        function SlimScroll(){
            if ($(window).width() > 991) {
                let ContentHeight = $('.js-left-pitch-area').height();
                $('.scrollbar').mCustomScrollbar({
                    scrollButtons:{enable:true},
                    theme:"light-thick",
                    scrollbarPosition:"outside",
                    mouseWheel:{ enable: true }
                });
                $(function(){
                    $('.player-data').height(ContentHeight);
                });
            } else {
                $('.scrollbar').mCustomScrollbar("destroy");
            }
        }
        $(window).bind("load", function() {
            SlimScroll();
        });
        $(window).on("orientationchange, resize", function(event) {
            SlimScroll();
        });

        $(function () {
            $('.js-player-position-select2').select2();
            $('.js-player-position2-select2').select2({
                dropdownParent: $('#full-screen-modal')
            });
            $('.js-club-select2').select2();
            $('.js-club2-select2').select2({
                dropdownParent: $('#full-screen-modal')
            });
        });

        // if ($(window).width() > 767) {
            fitty('.player-wrapper-title', {
                minSize: 7,
                maxSize: 11
            });
        // }
    </script>
@endpush

@push('header-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="top-navigation-bar">
                    <li>
                        <a href="javascript:void(0);" onclick="javascript:history.back();">
                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                        </a>
                    </li>
                    <li class="text-center has-dropdown has-arrow">
                        League name
                        <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span>
                    </li>
                    <li class="text-right">
                        <a href="#">
                            <span><i class="fas fa-cog"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endpush

@push('footer-content')
    @include('partials.auth.footer')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 d-lg-none">
                            <div class="bg-white">
                                <div class="data-container-area">
                                    <div class="player-data-container auction-data-container">
                                        <div class="auction-content-wrapper p-2">
                                            <div class="d-flex justify-content-space-between">
                                                <div class="auction-content d-flex">
                                                    <div class="auction-crest mr-2">
                                                        <img src="{{ asset('assets/frontend/img/league/league.svg')}}">
                                                    </div>
                                                    <div class="auction-body">
                                                        <p class="font-weight-bold m-0">League Name</p>
                                                        <p class="m-0 small">3 / 14 players</p>
                                                    </div>
                                                </div>

                                                <div class="remaining-budget text-right py-1 px-2">
                                                    <h6 class="text-uppercase m-0 font-weight-bold">budget</h6>
                                                    <p class="m-0 amount">&euro;180m</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="js-left-pitch-area">
                                <div class="pitch-layout live-auction">
                                    <div class="pitch-area">
                                        <div class="pitch-image">
                                            <img class="lazyload" src="{{ asset('assets/frontend/img/pitch/pitch-1.jpg')}}" data-src="{{ asset('assets/frontend/img/pitch/pitch-1.svg') }}" alt="">
                                        </div>
                                        <div class="pitch-players-standing">
                                            <div class="pitch-player-position-wrapper">
                                                <div class="player-position-view">
                                                    <div class="player-position-grid gutters-tiny has-player">
                                                        <div class="position-wrapper">
                                                            <div class="position-action-area">
                                                                <div>
                                                                    <span class="player-position-indicator">
                                                                        <img src="{{ asset('assets/frontend/img/auction/has-player.png')}}">
                                                                    </span>
                                                                    <span class="standing-view-player-position is-gk position-relative">GK</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @for ($i=0; $i<10; $i++)

                                                        <div class="player-position-col">
                                                            <div class="player-wrapper auction-player-wrapper">
                                                                <div class="player-wrapper-img hud_gk">
                                                                    <div class="transfer-process">
                                                                        <span><i class="fas fa-times"></i></span>
                                                                    </div>
                                                                    <div class="time-indicator d-lg-none">
                                                                        <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                                                                    </div>
                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-3.svg')}}" alt=""> --}}
                                                                </div>
                                                                <div class="player-wrapper-body">
                                                                    <div class="badge-area">
                                                                        <div class="custom-badge is-mf">MF</div>
                                                                        <div class="time-indicator d-none d-lg-inline-block">
                                                                            <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="player-wrapper-title">Richarlison Richarlison</div>
                                                                    <div class="player-wrapper-description">
                                                                        <div class="player-wrapper-text justify-content-end">
                                                                            <div class="player-points"><span class="points">30</span> pts</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endfor

                                                        <div class="player-position-col">
                                                            <a href="" class="player-wrapper auction-player-wrapper" data-toggle="modal" data-target="#full-screen-modal">
                                                                <div class="player-wrapper-img hud_gk">
                                                                    <div class="time-indicator d-lg-none">
                                                                        <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                                                                    </div>
                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-3.svg')}}" alt=""> --}}
                                                                </div>
                                                                <div class="player-wrapper-body">
                                                                    <div class="badge-area">
                                                                        <div class="custom-badge is-mf">MF</div>
                                                                        <div class="time-indicator d-none d-lg-inline-block">
                                                                            <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="player-wrapper-title">Richarlison</div>
                                                                    <div class="player-wrapper-description">
                                                                        <div class="player-wrapper-text">
                                                                            <div class="player-fixture-sch">
                                                                                <span class="schedule-day">whu</span>
                                                                                <span class="schedule-date">30/11</span>
                                                                            </div>
                                                                            <div class="player-points"><span class="points">30</span> pts</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="player-position-grid gutters-tiny has-player">
                                                        <div class="position-wrapper">
                                                            <div class="position-action-area">
                                                                <div>
                                                                    <span class="player-position-indicator">
                                                                        <img src="{{ asset('assets/frontend/img/auction/has-player.png')}}">
                                                                    </span>
                                                                    <span class="standing-view-player-position is-fb position-relative">fb</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="player-position-col">
                                                            <div class="player-wrapper auction-player-wrapper">
                                                                <div class="player-wrapper-img hud_gk">
                                                                    {{-- <div class="time-indicator d-lg-none">
                                                                        <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                                                                    </div> --}}
                                                                </div>
                                                                <div class="player-wrapper-body">
                                                                    <div class="badge-area">
                                                                        <div class="custom-badge is-gk">GK</div>
                                                                        {{-- <div class="time-indicator d-none d-lg-inline-block">
                                                                            <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                                                                        </div> --}}
                                                                    </div>
                                                                    <div class="player-wrapper-title">Valencia</div>
                                                                    <div class="player-wrapper-description">
                                                                        <div class="player-wrapper-text">
                                                                            <div class="player-fixture-sch">
                                                                                <span class="schedule-day">whu</span>
                                                                                <span class="schedule-date">30/11</span>
                                                                            </div>
                                                                            <div class="player-points"><span class="points">30</span> pts</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="player-position-col">
                                                            <div class="player-wrapper auction-player-wrapper">
                                                                <div class="player-wrapper-img hud_gk">
                                                                    {{-- <div class="time-indicator d-lg-none">
                                                                        <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                                                                    </div> --}}
                                                                </div>
                                                                <div class="player-wrapper-body">
                                                                    <div class="badge-area">
                                                                        <div class="custom-badge is-gk">GK</div>
                                                                        {{-- <div class="time-indicator d-none d-lg-inline-block">
                                                                            <img src="{{ asset('assets/frontend/img/auction/time-indicator.png')}}">
                                                                        </div> --}}
                                                                    </div>
                                                                    <div class="player-wrapper-title">Valencia</div>
                                                                    <div class="player-wrapper-description">
                                                                        <div class="player-wrapper-text">
                                                                            <div class="player-fixture-sch">
                                                                                <span class="schedule-day">whu</span>
                                                                                <span class="schedule-date">30/11</span>
                                                                            </div>
                                                                            <div class="player-points"><span class="points">30</span> pts</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="player-position-grid gutters-tiny has-no-player justify-content-between">
                                                        <div class="position-wrapper">
                                                            <div class="position-action-area">
                                                                <div>
                                                                    <span class="player-position-indicator">
                                                                        <img src="{{ asset('assets/frontend/img/auction/no-player.png')}}">
                                                                    </span>
                                                                    <span class="standing-view-player-position is-cb position-relative">cb</span>
                                                                </div>
                                                                <div>
                                                                    <span class="standing-view-player-position info-text">This team does not have any centre backs</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="player-position-grid gutters-tiny has-no-player justify-content-between">
                                                        <div class="position-wrapper">
                                                            <div class="position-action-area">
                                                                <div>
                                                                    <span class="player-position-indicator">
                                                                        <img src="{{ asset('assets/frontend/img/auction/no-player.png')}}">
                                                                    </span>
                                                                    <span class="standing-view-player-position is-mf position-relative">mf</span>
                                                                </div>
                                                                <div>
                                                                    <span class="standing-view-player-position info-text">This team does not have any midfielders</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="player-position-grid gutters-tiny has-no-player justify-content-between">
                                                        <div class="position-wrapper">
                                                            <div class="position-action-area">
                                                                <a href="#">
                                                                    <span class="player-position-indicator">
                                                                        <img src="{{ asset('assets/frontend/img/auction/no-player.png')}}">
                                                                    </span>
                                                                    <span class="standing-view-player-position is-st position-relative">st</span>
                                                                </a>
                                                                <div>
                                                                    <span class="standing-view-player-position info-text">This team does not have any strikers</span>
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
                        </div>

                        <div class="col-lg-6">
                            <div class="player-data scrollbar">
                                <div class="data-container-area">
                                    <div class="player-data-container auction-data-container">
                                        <div class="auction-content-wrapper p-3">
                                            <div class="d-none d-lg-flex justify-content-space-between">
                                                <div class="auction-content d-flex">
                                                    <div class="auction-crest mr-2">
                                                        <img src="{{ asset('assets/frontend/img/league/league.svg')}}">
                                                    </div>
                                                    <div class="auction-body">
                                                        <p class="font-weight-bold m-0">League Name</p>
                                                        <p class="m-0 small">3 / 14 players</p>
                                                    </div>
                                                </div>

                                                <div class="remaining-budget text-right py-1 px-2">
                                                    <h6 class="text-uppercase m-0 font-weight-bold">budget</h6>
                                                    <p class="m-0 amount">&euro;180m</p>
                                                </div>
                                            </div>

                                            <div class="player-data-wrapper d-none d-md-block">
                                                <div class="row gutters-md mt-3">
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

                                                <div class="row gutters-sm">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="player-name">Player Name</label>
                                                            <input type="text" class="form-control" id="player-name" name="player-name" placeholder="e.g Harry Kane">
                                                        </div>

                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="bought-player">
                                                            <label class="custom-control-label" for="bought-player">Hide bought players</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="player-data-wrapper d-none d-md-block">
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
                                                        <tr class="is-success">
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
                                                                <div class="won-player"><span class="bg-primary text-white py-1 px-2 text-uppercase">Won <i class="far fa-check"></i></span></div>
                                                            </td>
                                                        </tr>

                                                        <tr class="is-disabled">
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

                                                        <tr class="is-disabled">
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

                                                        <tr class="is-disabled">
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
                                                                <div class="text-muted text-uppercase won-by is-disabled">
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

                                                        <tr class="is-disabled">
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

                                                        <tr class="is-disabled">
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

                                                        <tr class="is-disabled">
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
        </div>
    </div>

@endsection

@push ('modals')
    <!-- Modal -->
    <div class="modal fade nested-modal" id="edit-bid-modal" tabindex="-1" role="dialog" aria-labelledby="edit-bid-modalLabel" aria-hidden="true">
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
    <div class="modal fade nested-modal" id="bid-modal" tabindex="-1" role="dialog" aria-labelledby="bid-modalLabel" aria-hidden="true">
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

    <div class="full-screen-modal" id="full-screen-modal" tabindex="-1" role="dialog" aria-labelledby="full-screen-modal" aria-hidden="true">
        <div class="modal-card" role="document">
            <div class="modal-card-head">
                <div class="header">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li>
                                        <a href="javascript:void(0);" data-dismiss="modal" aria-label="Close">
                                            <span><i class="fas fa-chevron-left mr-2"></i></span>Back
                                        </a>
                                    </li>
                                    <li class="text-center has-dropdown has-arrow">
                                        League name
                                        <span class="align-middle ml-2"><i class="fas fa-chevron-down"></i></span>
                                    </li>
                                    <li class="text-right">
                                        <a href="#">
                                            <span><i class="fas fa-cog"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-card-body">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary my-1 f-12 rounded-0" id="pills-tab-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link px-1" id="team-tab" data-toggle="pill" href="#teamData" role="tab" aria-controls="teamData" aria-selected="false">Teams</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="bid-tab" data-toggle="pill" href="#bidData" role="tab" aria-controls="bidData" aria-selected="false">Bids</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="player-tab" data-toggle="pill" href="#playerData" role="tab" aria-controls="playerData" aria-selected="true">Players</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="pills-tabContent-1">
                    <div class="tab-pane fade" id="teamData" role="tabpanel" aria-labelledby="team-tab">Team data</div>
                    <div class="tab-pane fade" id="bidData" role="tabpanel" aria-labelledby="bid-tab">Bid data</div>
                    <div class="tab-pane fade show active" id="playerData" role="tabpanel" aria-labelledby="player-tab">
                        <div class="player-data">
                            <div class="data-container-area">
                                <div class="player-data-container">
                                    <div class="auction-content-wrapper p-2">
                                        <div class="d-flex justify-content-space-between">
                                            <div class="auction-content d-flex">
                                                <div class="auction-crest mr-2">
                                                    <img src="{{ asset('assets/frontend/img/league/league.svg')}}">
                                                </div>
                                                <div class="auction-body">
                                                    <p class="font-weight-bold m-0">League Name</p>
                                                    <p class="m-0 small">3 / 14 players</p>
                                                </div>
                                            </div>

                                            <div class="remaining-budget text-right py-1 px-2">
                                                <h6 class="text-uppercase m-0 font-weight-bold">budget</h6>
                                                <p class="m-0 amount">&euro;180m</p>
                                            </div>
                                        </div>

                                        <div class="row gutters-md mt-3">
                                            <div class="col-6">
                                                {{-- <div class="form-group">
                                                    <label for="position">Position</label>
                                                    <select class="form-control" id="position">
                                                        <option>Goalkeeper</option>
                                                        <option>Full Backs</option>
                                                        <option>Center Backs</option>
                                                        <option>Midfielders</option>
                                                        <option>Strikers</option>
                                                    </select>
                                                </div> --}}

                                                <div class="form-group">
                                                    <label for="position2">Position</label>
                                                    <select class="js-player-position2-select2" id="position2">
                                                        <option value="Goalkeeper">Goalkeeper</option>
                                                        <option value="Full Backs">Full Backs</option>
                                                        <option value="Center Backs">Center Backs</option>
                                                        <option value="Midfielders">Midfielders</option>
                                                        <option value="Midfielders">Strikers</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                {{-- <div class="form-group">
                                                    <label for="club">Club</label>
                                                    <select class="form-control" id="club">
                                                        <option>All</option>
                                                    </select>
                                                </div> --}}

                                                <div class="form-group">
                                                    <label for="club2">Club</label>
                                                    <select class="js-club2-select2" id="club2">
                                                        <option>All</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row gutters-sm">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="player-name">Player Name</label>
                                                    <input type="text" class="form-control" id="player-name" name="player-name" placeholder="e.g Harry Kane">
                                                </div>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="bought-player-1">
                                                    <label class="custom-control-label" for="bought-player-1">Hide bought players</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="table-responsive"> --}}
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
                                                <tr class="is-success">
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
                                                        <div class="won-player"><span class="bg-primary text-white py-1 px-2 text-uppercase">Won <i class="far fa-check"></i></span></div>
                                                    </td>
                                                </tr>

                                                <tr class="is-disabled">
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

                                                <tr class="is-disabled">
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

                                                <tr class="is-disabled">
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
                                                            <div class="icon-add"><a href=""><span><img src="{{ asset('assets/frontend/img/auction/bid-add.svg')}}"></span></a></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    {{-- </div> --}}

                                    {{-- <div class="table-responsive"> --}}
                                        <table class="table custom-table auction-table m-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-uppercase">player</th>
                                                    <th class="text-center text-uppercase">pld</th>
                                                    <th class="text-center text-uppercase">pts</th>
                                                    <th class="text-center">GLS</th>
                                                    <th class="text-center">ass</th>
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
                                                    <td class="text-center">17</td>
                                                    <td class="text-center">19</td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">3</td>
                                                    <td class="text-center">
                                                        <div class="icon-edit"><a href="#edit-bid-modal" data-toggle="modal" ><span><img src="{{ asset('assets/frontend/img/auction/bid-edit.svg')}}"></span></a></div>
                                                    </td>
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
                                                    <td class="text-center">43</td>
                                                    <td class="text-center">20</td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">0</td>
                                                    <td class="text-center">
                                                        <div class="icon-add"><a href=""><span><img src="{{ asset('assets/frontend/img/auction/bid-add.svg')}}"></span></a></div>
                                                    </td>
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
                                                    <td class="text-center">4</td>
                                                    <td class="text-center">13</td>
                                                    <td class="text-center">2</td>
                                                    <td class="text-center">-2</td>
                                                    <td class="text-center">
                                                        <div class="icon-add"><a href=""><span><img src="{{ asset('assets/frontend/img/auction/bid-add.svg')}}"></span></a></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-card-foot">
                <div class="footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="footer-navigation">
                                <div class="navigation-tab">
                                        <a class="navigation-link" href="#">
                                            <span class="icon">
                                                <i class="fas fa-tshirt"></i>
                                            </span>
                                            <span>Team</span>
                                        </a>
                                    </div>
                                    <div class="navigation-tab">
                                        <a class="navigation-link" href="#">
                                            <span class="icon">
                                                <i class="fas fa-trophy"></i>
                                            </span>
                                            <span>League</span>
                                        </a>
                                    </div>
                                    <div class="navigation-tab">
                                        <a class="navigation-link" href="#">
                                            <span class="icon">
                                                <i class="fas fa-exchange-alt"></i>
                                            </span>
                                            <span>Transfers</span>
                                        </a>
                                    </div>
                                    <div class="navigation-tab">
                                        <a class="navigation-link" href="#">
                                            <span class="icon">
                                                <i class="fas fa-comment"></i>
                                            </span>
                                            <span>Chat</span>
                                        </a>
                                    </div>
                                    <div class="navigation-tab">
                                        <a class="navigation-link" href="#">
                                            <span class="icon">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </span>
                                            <span>More</span>
                                        </a>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
