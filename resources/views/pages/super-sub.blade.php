@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('footer-content')
    @include('partials.auth.footer')
@endpush

@push('plugin-styles')
<link rel="stylesheet" href="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('/js/plugins/fitty/dist/fitty.min.js')}}"></script>
<script src="{{ asset('/js/plugins/scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
@endpush

@push('page-scripts')
<script>
    $(document).ready(function() {
        $('.player-carousel').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            navText: ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
            dots: false,
            responsive: {
                0: {
                    items: 4
                },
                720: {
                    items: 5
                },
                1140: {
                    items: 5
                }
            }
        });

        $('.js-owl-carousel-date-info').owlCarousel({
            loop: false,
            margin: 1,
            nav: false,
            dots: false,
            responsive: {
                0: {
                    items: 6
                },
                720: {
                    items: 10
                },
                1140: {
                    items: 10
                }
            }
        });
    });
    $(".popover-div").popover({
        boundary: '#squad',
        // selector: true,
        // viewport: '#squad',
        html: true,
        container: '.popover-div',
        content: function() {
            return $('#popover-status').html();
        }
    });
    $(".popover-div-1").popover({
        boundary: '#squad',
        html: true,
        container: '.popover-div-1',
        content: function() {
            return $('#popover-status-1').html();
        }
    });
    function close_popover(){
        $('#popover-status').popover('hide');
        $('#popover-status-1').popover('hide');
    }
    function SlimScroll(){
        if ($(window).width() > 991) {
            let ContentHeight = $('.js-left-pitch-area').height();
            $('.scrollbar').mCustomScrollbar({
                scrollButtons:{enable:true},
                theme:"light-thick",
                scrollbarPosition:"outside",
                mouseWheel:{ enable: true }
            });
            // let PDataContainerHeight = PitchHeight - 90;
            // $(".player-data-container").css("height", ContentHeight);

                $(function(){
                    $('.player-data').height(ContentHeight);
                });
                // $('.player-data-container').slimScroll({
                //     height: ContentHeight
                // });
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

    // if ($(window).width() > 767) {
        fitty('.player-wrapper-title', {
            minSize: 7,
            maxSize: 11
        });
    // }
</script>
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6">
                            <div class="js-left-pitch-area">
                                <div class="row no-gutters">
                                    <div class="col-12 squad-Details" id="squad-Details">
                                        <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary m-0" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="squad-tab" data-toggle="pill" href="#squad" role="tab" aria-controls="squad" aria-selected="true">Squad</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="Subs-tab" data-toggle="pill" href="#Subs" role="tab" aria-controls="Subs" aria-selected="false">Subs</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="Supersubs-tab" data-toggle="pill" href="#Supersubs" role="tab" aria-controls="Supersubs" aria-selected="false">Supersubs</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12" id="Js-tab-area">
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="squad" role="tabpanel" aria-labelledby="squad-tab">
                                                <div class="text-center inner-tab py-1">
                                                    <ul class="nav nav-pills theme-tabs theme-tabs-dark m-0 d-inline-flex border-0" id="pills-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="week-tab" data-toggle="pill" href="#week" role="tab" aria-controls="week" aria-selected="true">WEEK 0</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="total-tab" data-toggle="pill" href="#total" role="tab" aria-controls="total" aria-selected="false">TOTAL 317</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="fa-cup-round-tab" data-toggle="pill" href="#fa-cup-round" role="tab" aria-controls="fa-cup-round" aria-selected="false">FA CUP ROUND 2</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="fa-cup-total-tab" data-toggle="pill" href="#fa-cup-total" role="tab" aria-controls="fa-cup-total" aria-selected="false">FA CUP TOTAL 14</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="pitch-layout">
                                                    <div class="pitch-area">
                                                        <div class="pitch-image">
                                                            <img class="lazyload" src="{{ asset('assets/frontend/img/pitch/pitch-1.jpg')}}" data-src="{{ asset('assets/frontend/img/pitch/pitch-1.svg') }}" alt="">
                                                        </div>
                                                        <div class="pitch-players-standing">
                                                            <div class="standing-area">
                                                                <div class="standing-view">
                                                                    <div class="standing-view-grid gutters-tiny">
                                                                        <div class="standing-col">
                                                                            <a href="#" class="player-wrapper" data-toggle="modal" data-target="#players-info">
                                                                                <div class="player-wrapper-img che_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-6.svg')}}" alt=""> --}}

                                                                                    <div class="transfer-process">
                                                                                        <span><i class="fas fa-times"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-gk">GK</div>
                                                                                        <div class="custom-badge"><img src="http://shreya-fantasyleague.dev.aecortech.com/assets/frontend/img/status/late.svg" class="status-img"></div>
                                                                                        <div class="custom-badge"><img src="http://shreya-fantasyleague.dev.aecortech.com/assets/frontend/img/status/injured.svg" class="status-img"></div>
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
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="standing-view-grid gutters-tiny">
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper is-disable">
                                                                                <div class="player-wrapper-img mun_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper is-selected">
                                                                                <div class="player-wrapper-img tot_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-4.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-fb">FB</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Luiz</div>
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
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img tot_gk">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-cb">CB</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Tackie Mensah Welbeck</div>
                                                                                    <div class="player-wrapper-description">
                                                                                        <div class="player-wrapper-text">
                                                                                            <div class="player-fixture-sch">
                                                                                                <span class="schedule-day">whu</span>
                                                                                                <span class="schedule-date">30/11</span>
                                                                                            </div>
                                                                                            <div class="player-points"><span class="points">31</span> pts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img ars_player-selected">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-2.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-cb">CB</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Fernandes da Silva Junior</div>
                                                                                    <div class="player-wrapper-description">
                                                                                        <div class="player-wrapper-text">
                                                                                            <div class="player-fixture-sch">
                                                                                                <span class="schedule-day">whu</span>
                                                                                                <span class="schedule-date">30/11</span>
                                                                                            </div>
                                                                                            <div class="player-points"><span class="points">31</span> pts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper popover-div-1" data-toggle="popover" data-placement="top" data-html="true">
                                                                                <div class="player-wrapper-img ars_gk">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-4.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-cb">CB</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Alderweireld</div>
                                                                                    <div class="player-wrapper-description">
                                                                                        <div class="player-wrapper-text">
                                                                                            <div class="player-fixture-sch">
                                                                                                <span class="schedule-day">whu</span>
                                                                                                <span class="schedule-date">30/11</span>
                                                                                            </div>
                                                                                            <div class="player-points"><span class="points">31</span> pts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div id="popover-status-1" class="d-none">
                                                                                <div class="squad-modal">
                                                                                    <div class="squad-modal-body">
                                                                                        <div class="player-wrapper-status">
                                                                                            <span>
                                                                                                <img src="{{ asset('assets/frontend/img/status/suspension.svg')}}" class="img-status">
                                                                                            </span> Suspended until 29/9/2019
                                                                                        </div>

                                                                                        <a href="#" class="link-nostyle squad-modal-stepper">
                                                                                            <div class="squad-modal-content has-icon">
                                                                                                <div class="squad-modal-label">
                                                                                                    <div class="badge-area">
                                                                                                        <div class="custom-badge custom-badge-xl is-square is-st">ST</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="squad-modal-body">
                                                                                                    <div class="squad-modal-title">Gabriel Jesus</div>
                                                                                                    <div class="squad-modal-text">Manchester City</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>

                                                                                        <ul class="list-unstyled">
                                                                                            <li>week<span class="points">0 pts</span></li>
                                                                                            <li>month<span class="points">5 pts</span></li>
                                                                                            <li>total<span class="points">16 pts</span></li>
                                                                                        </ul>

                                                                                        <div class="mt-3"></div>

                                                                                        <a href="#" class="link-nostyle squad-modal-stepper">
                                                                                            <div class="squad-modal-content has-icon">
                                                                                                <div class="squad-modal-label">
                                                                                                    <img src="{{ asset('assets/frontend/img/status/transfer.svg')}}" class="lbl-img">
                                                                                                </div>
                                                                                                <div class="squad-modal-body">
                                                                                                    <div class="squad-modal-title">Theo Walcott</div>
                                                                                                    <div class="squad-modal-text">Everton</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>

                                                                                        <div class="mt-2"></div>

                                                                                        <button type="button" class="btn btn-primary btn-block">Confirm</button>

                                                                                        <button type="button" class="btn btn-outline-dark btn-block" onclick="close_popover();">Cancel</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="standing-view-grid gutters-tiny">
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img car_gk">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img cry_gk-selected">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        {{-- @for ($i=0; $i<6; $i++) --}}
                                                                            <div class="standing-col">
                                                                                <div class="player-wrapper">
                                                                                    <div class="player-wrapper-img cry_player">
                                                                                        {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-4.svg')}}" alt=""> --}}
                                                                                    </div>
                                                                                    <div class="player-wrapper-body">
                                                                                        <div class="badge-area">
                                                                                            <div class="custom-badge is-mf">MF</div>
                                                                                            <div class="status-indicator"><span></span></div>
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
                                                                                </div>
                                                                            </div>
                                                                        {{-- @endfor --}}
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img hud_gk-selected">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-3.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="standing-view-grid gutters-tiny">
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper popover-div" data-toggle="popover" data-placement="top" data-html="true">
                                                                                <div class="player-wrapper-img ars_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-2.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-st">ST</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Luiz</div>
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

                                                                            <div id="popover-status" class="d-none">
                                                                                <div class="squad-modal">
                                                                                    <div class="squad-modal-body">
                                                                                        <div class="player-wrapper-status">
                                                                                            <span>
                                                                                                <img src="{{ asset('assets/frontend/img/status/suspension.svg')}}" class="img-status">
                                                                                            </span> Suspended until 29/9/2019
                                                                                        </div>

                                                                                        <a href="#" class="link-nostyle squad-modal-stepper">
                                                                                            <div class="squad-modal-content has-icon">
                                                                                                <div class="squad-modal-label">
                                                                                                    <div class="badge-area">
                                                                                                        <div class="custom-badge custom-badge-xl is-square is-st">ST</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="squad-modal-body">
                                                                                                    <div class="squad-modal-title">Gabriel Jesus</div>
                                                                                                    <div class="squad-modal-text">Manchester City</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>

                                                                                        <ul class="list-unstyled">
                                                                                            <li>week<span class="points">0 pts</span></li>
                                                                                            <li>month<span class="points">5 pts</span></li>
                                                                                            <li>total<span class="points">16 pts</span></li>
                                                                                        </ul>

                                                                                        <div class="mt-3"></div>

                                                                                        <a href="#" class="link-nostyle squad-modal-stepper">
                                                                                            <div class="squad-modal-content has-icon">
                                                                                                <div class="squad-modal-label">
                                                                                                    <img src="{{ asset('assets/frontend/img/status/transfer.svg')}}" class="lbl-img">
                                                                                                </div>
                                                                                                <div class="squad-modal-body">
                                                                                                    <div class="squad-modal-title">Theo Walcott</div>
                                                                                                    <div class="squad-modal-text">Everton</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>

                                                                                        <div class="mt-2"></div>

                                                                                        <button type="button" class="btn btn-primary btn-block">Confirm</button>

                                                                                        <button type="button" class="btn btn-outline-dark btn-block" onclick="close_popover();">Cancel</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img bur_gk">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img bur_player-selected">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-3.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-st">ST</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Luiz</div>
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="fixed-bottom-content">
                                                        <div class="player-data-carousel">
                                                            <div class="owl-carousel owl-theme player-carousel">
                                                                @for ($i=0; $i<30; $i++)
                                                                    <div class="item">
                                                                        <a class="player-list-info" data-togle="sidebar">
                                                                            <div class="player-wrapper side-by-side">
                                                                                <div class="player-wrapper-img ars_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-6.svg')}}" alt=""> --}}

                                                                                    <div class="player-status">
                                                                                        <img src="http://shreya-fantasyleague.dev.aecortech.com/assets/frontend/img/status/late.svg" class="status-img">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-gk">GK</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                        </a>
                                                                    </div>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="Subs" role="tabpanel" aria-labelledby="Subs-tab">
                                            </div>
                                            <div class="tab-pane fade" id="Supersubs" role="tabpanel" aria-labelledby="Supersubs-tab">
                                                <div class="schedule-supersub">
                                                    <div class="sliding-area">
                                                        <div class="sliding-nav">
                                                            <div class="sliding-items">
                                                                <div class="owl-carousel js-owl-carousel-date-info js-month-year-filter owl-theme sliding-items-info">
                                                                    <div class="item info-block js-month" data-start-date="2018-08-01" data-end-date="2018-08-31">
                                                                        <a href="javascript:void(0)" class="info-block-content">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2018-09-01" data-end-date="2018-09-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2018-10-01" data-end-date="2018-10-31">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2018-11-01" data-end-date="2018-11-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2018-12-01" data-end-date="2018-12-31">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-01-01" data-end-date="2019-01-31">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-02-01" data-end-date="2019-02-28">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-03-01" data-end-date="2019-03-31">
                                                                        <a href="javascript:void(0)" class="info-block-content    is-active ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                    <div class="item info-block js-month" data-start-date="2019-04-01" data-end-date="2019-04-30">
                                                                        <a href="javascript:void(0)" class="info-block-content  ">
                                                                            <div class="block-section">
                                                                                <div class="title">
                                                                                    29/01
                                                                                </div>
                                                                                <div class="desc">
                                                                                    19:45
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="display-date-time">
                                                    Tuesday 29th January - 19:45
                                                </div>

                                                <div class="pitch-layout">
                                                    <div class="pitch-area">
                                                        <div class="pitch-image">
                                                            <img class="lazyload" src="{{ asset('assets/frontend/img/pitch/pitch-1.jpg')}}" data-src="{{ asset('assets/frontend/img/pitch/pitch-1.svg') }}" alt="">
                                                        </div>
                                                        <div class="pitch-players-standing">
                                                            <div class="standing-area">
                                                                <div class="standing-view">
                                                                    <div class="standing-view-grid gutters-tiny">
                                                                        <div class="standing-col">
                                                                            <a href="#" class="player-wrapper" data-toggle="modal" data-target="#players-info">
                                                                                <div class="player-wrapper-img che_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-6.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-gk">GK</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="standing-view-grid gutters-tiny">
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper is-disable">
                                                                                <div class="player-wrapper-img mun_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper is-selected">
                                                                                <div class="player-wrapper-img tot_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-4.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-fb">FB</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Luiz</div>
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
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img tot_gk">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-cb">CB</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Alderweireld</div>
                                                                                    <div class="player-wrapper-description">
                                                                                        <div class="player-wrapper-text">
                                                                                            <div class="player-fixture-sch">
                                                                                                <span class="schedule-day">whu</span>
                                                                                                <span class="schedule-date">30/11</span>
                                                                                            </div>
                                                                                            <div class="player-points"><span class="points">31</span> pts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img ars_player-selected">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-2.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-cb">CB</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Alderweireld</div>
                                                                                    <div class="player-wrapper-description">
                                                                                        <div class="player-wrapper-text">
                                                                                            <div class="player-fixture-sch">
                                                                                                <span class="schedule-day">whu</span>
                                                                                                <span class="schedule-date">30/11</span>
                                                                                            </div>
                                                                                            <div class="player-points"><span class="points">31</span> pts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper popover-div-1" data-toggle="popover" data-placement="top" data-html="true">
                                                                                <div class="player-wrapper-img ars_gk">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-4.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-cb">CB</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Alderweireld</div>
                                                                                    <div class="player-wrapper-description">
                                                                                        <div class="player-wrapper-text">
                                                                                            <div class="player-fixture-sch">
                                                                                                <span class="schedule-day">whu</span>
                                                                                                <span class="schedule-date">30/11</span>
                                                                                            </div>
                                                                                            <div class="player-points"><span class="points">31</span> pts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div id="popover-status-1" class="d-none">
                                                                                <div class="squad-modal">
                                                                                    <div class="squad-modal-body">
                                                                                        <div class="player-wrapper-status">
                                                                                            <span>
                                                                                                <img src="{{ asset('assets/frontend/img/status/suspension.svg')}}" class="img-status">
                                                                                            </span> Suspended until 29/9/2019
                                                                                        </div>

                                                                                        <a href="#" class="link-nostyle squad-modal-stepper">
                                                                                            <div class="squad-modal-content has-icon">
                                                                                                <div class="squad-modal-label">
                                                                                                    <div class="badge-area">
                                                                                                        <div class="custom-badge custom-badge-xl is-square is-st">ST</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="squad-modal-body">
                                                                                                    <div class="squad-modal-title">Gabriel Jesus</div>
                                                                                                    <div class="squad-modal-text">Manchester City</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>

                                                                                        <ul class="list-unstyled">
                                                                                            <li>week<span class="points">0 pts</span></li>
                                                                                            <li>month<span class="points">5 pts</span></li>
                                                                                            <li>total<span class="points">16 pts</span></li>
                                                                                        </ul>

                                                                                        <div class="mt-3"></div>

                                                                                        <a href="#" class="link-nostyle squad-modal-stepper">
                                                                                            <div class="squad-modal-content has-icon">
                                                                                                <div class="squad-modal-label">
                                                                                                    <img src="{{ asset('assets/frontend/img/status/transfer.svg')}}" class="lbl-img">
                                                                                                </div>
                                                                                                <div class="squad-modal-body">
                                                                                                    <div class="squad-modal-title">Theo Walcott</div>
                                                                                                    <div class="squad-modal-text">Everton</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>

                                                                                        <div class="mt-2"></div>

                                                                                        <button type="button" class="btn btn-primary btn-block">Confirm</button>

                                                                                        <button type="button" class="btn btn-outline-dark btn-block" onclick="close_popover();">Cancel</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="standing-view-grid gutters-tiny">
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img car_gk">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img cry_gk-selected">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img cry_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-4.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img hud_gk-selected">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-3.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="standing-view-grid gutters-tiny justify-content-center">
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper popover-div" data-toggle="popover" data-placement="top" data-html="true">
                                                                                <div class="player-wrapper-img ars_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-2.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-st">ST</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Luiz</div>
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

                                                                            <div id="popover-status" class="d-none">
                                                                                <div class="squad-modal">
                                                                                    <div class="squad-modal-body">
                                                                                        <div class="player-wrapper-status">
                                                                                            <span>
                                                                                                <img src="{{ asset('assets/frontend/img/status/suspension.svg')}}" class="img-status">
                                                                                            </span> Suspended until 29/9/2019
                                                                                        </div>

                                                                                        <a href="#" class="link-nostyle squad-modal-stepper">
                                                                                            <div class="squad-modal-content has-icon">
                                                                                                <div class="squad-modal-label">
                                                                                                    <div class="badge-area">
                                                                                                        <div class="custom-badge custom-badge-xl is-square is-st">ST</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="squad-modal-body">
                                                                                                    <div class="squad-modal-title">Gabriel Jesus</div>
                                                                                                    <div class="squad-modal-text">Manchester City</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>

                                                                                        <ul class="list-unstyled">
                                                                                            <li>week<span class="points">0 pts</span></li>
                                                                                            <li>month<span class="points">5 pts</span></li>
                                                                                            <li>total<span class="points">16 pts</span></li>
                                                                                        </ul>

                                                                                        <div class="mt-3"></div>

                                                                                        <a href="#" class="link-nostyle squad-modal-stepper">
                                                                                            <div class="squad-modal-content has-icon">
                                                                                                <div class="squad-modal-label">
                                                                                                    <img src="{{ asset('assets/frontend/img/status/transfer.svg')}}" class="lbl-img">
                                                                                                </div>
                                                                                                <div class="squad-modal-body">
                                                                                                    <div class="squad-modal-title">Theo Walcott</div>
                                                                                                    <div class="squad-modal-text">Everton</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </a>

                                                                                        <div class="mt-2"></div>

                                                                                        <button type="button" class="btn btn-primary btn-block">Confirm</button>

                                                                                        <button type="button" class="btn btn-outline-dark btn-block" onclick="close_popover();">Cancel</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img bur_gk">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-5.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-mf">MF</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                            </div>
                                                                        </div>
                                                                        <div class="standing-col">
                                                                            <div class="player-wrapper">
                                                                                <div class="player-wrapper-img bur_player-selected">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-3.svg')}}" alt=""> --}}
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-st">ST</div>
                                                                                        <div class="status-indicator"><span></span></div>
                                                                                    </div>
                                                                                    <div class="player-wrapper-title">Luiz</div>
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="fixed-bottom-content">
                                                        <div class="player-data-carousel">
                                                            <div class="owl-carousel owl-theme player-carousel">
                                                                @for ($i=0; $i<30; $i++)
                                                                    <div class="item">
                                                                        <a class="player-list-info" data-togle="sidebar">
                                                                            <div class="player-wrapper side-by-side">
                                                                                <div class="player-wrapper-img ars_player">
                                                                                    {{-- <img class="lazyload tshirt" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/icon-team-6.svg')}}" alt=""> --}}

                                                                                    <div class="player-status">
                                                                                        <img src="http://shreya-fantasyleague.dev.aecortech.com/assets/frontend/img/status/late.svg" class="status-img">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="player-wrapper-body">
                                                                                    <div class="badge-area">
                                                                                        <div class="custom-badge is-gk">GK</div>
                                                                                        <div class="status-indicator"><span></span></div>
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
                                                                        </a>
                                                                    </div>
                                                                @endfor
                                                            </div>
                                                        </div>

                                                        <div class="action-buttons">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button type="button" class="btn btn-primary btn-block">Accept</button>
                                                                </div>

                                                                <div class="col-6">
                                                                    <button type="button" class="btn btn-outline-white btn-block has-badge">
                                                                        Edit <span class="custom-badge custom-badge-secondary">3</span>
                                                                    </button>
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
                                    <div class="player-data-container">
                                        <div class="close-player-data-container">
                                            <span><a href=""><i class="fas fa-times-circle"></i></a></span>
                                        </div>
                                        <div class="player-data-container-slim">
                                            <div class="player-banner-wrapper">
                                                <div class="player-banner-img">
                                                    <div class="player-banner-watermark">
                                                        <img class="player-banner-watermark-logo" src="{{ asset('assets/frontend/img/background/player-banner-bg.svg') }}" alt="">
                                                    </div>
                                                    <img class="player-crest" src="{{ asset('assets/frontend/img/status/player.jpg') }}" alt="">
                                                </div>
                                                <div class="player-banner-body">
                                                    <div class="player-wrapper-status">
                                                        <span>
                                                            <img class="lazyload status-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/doubtful.svg') }}" alt="">
                                                        </span>
                                                        Doubtfull (illness)
                                                    </div>

                                                    <div class="link-nostyle squad-modal-stepper">
                                                        <div class="squad-modal-content">
                                                            <div class="squad-modal-label">
                                                                <div class="badge-area">
                                                                    <div class="custom-badge custom-badge-xl is-square is-fb">FB</div>
                                                                </div>
                                                            </div>
                                                            <div class="squad-modal-body">
                                                                <div class="squad-modal-title text-white">Luke Shaw</div>
                                                                <div class="squad-modal-text text-white">Manchester United</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-12">
                                                    <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary m-1 f-12" id="pills-tab-1" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link px-1 active" id="PremierLeague-tab" data-toggle="pill" href="#PremierLeague" role="tab" aria-controls="PremierLeague" aria-selected="true">Premier League</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="FACup-tab" data-toggle="pill" href="#FACup" role="tab" aria-controls="FACup" aria-selected="false">FA Cup</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="History-tab" data-toggle="pill" href="#History" role="tab" aria-controls="History" aria-selected="false">History</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-12">
                                                    <div class="tab-content" id="pills-tabContent-1">
                                                        <div class="tab-pane fade show active" id="PremierLeague" role="tabpanel" aria-labelledby="PremierLeague-tab">
                                                            <div class="table-responsive">
                                                                <table class="table text-center custom-table mb-0">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th></th>
                                                                            <th>PLD</th>
                                                                            <th>
                                                                                <div class="d-flex justify-content-center align-items-center">
                                                                                    GLS
                                                                                    <span class="custom-badge custom-badge-primary is-circle ml-1">G</span>
                                                                                </div>
                                                                            </th>
                                                                            <th>
                                                                                <div class="d-flex justify-content-center align-items-center">
                                                                                    ASS
                                                                                    <span class="custom-badge custom-badge-secondary is-circle ml-1">A</span>
                                                                                </div>
                                                                            </th>
                                                                            <th>CS</th>
                                                                            <th>GA</th>
                                                                            <th>TOT</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @for ($i=0; $i<30; $i++)
                                                                            <tr>
                                                                                <td class="text-dark">Home</td>
                                                                                <td>5</td>
                                                                                <td>1</td>
                                                                                <td>0</td>
                                                                                <td>0</td>
                                                                                <td>8</td>
                                                                                <td>0</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-dark">Away</td>
                                                                                <td>6</td>
                                                                                <td>0</td>
                                                                                <td>2</td>
                                                                                <td>1</td>
                                                                                <td>12</td>
                                                                                <td>0</td>
                                                                            </tr>
                                                                        @endfor
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td>Total</td>
                                                                            <td>11</td>
                                                                            <td>1</td>
                                                                            <td>2</td>
                                                                            <td>1</td>
                                                                            <td>20</td>
                                                                            <td>0</td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="FACup" role="tabpanel" aria-labelledby="FACup-tab">

                                                        </div>
                                                        <div class="tab-pane fade" id="History" role="tabpanel" aria-labelledby="History-tab">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table custom-table table-hover m-0 fixed-column">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-center">£M</th>
                                                        <th class="text-center">Points</th>
                                                        <th class="text-center">PLD</th>
                                                        <th class="text-center">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                GLS
                                                                <span class="custom-badge custom-badge-primary is-circle ml-1">G</span>
                                                            </div>
                                                        </th>
                                                        <th class="text-center">
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                ASS
                                                                <span class="custom-badge custom-badge-secondary is-circle ml-1">A</span>
                                                            </div>
                                                        </th>
                                                        <th class="text-center">CS</th>
                                                        <th class="text-center">GA</th>
                                                        <th class="text-center">wk</th>
                                                        <th class="text-center">mth</th>
                                                        <th class="text-center">total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">Kepa</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Chelsea</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">1.00</td>
                                                        <td class="text-center">43</td>
                                                        <td class="text-center">20</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-fb">FB</span>
                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">Allisson</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Liverpool</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">1.50</td>
                                                        <td class="text-center">4</td>
                                                        <td class="text-center">13</td>
                                                        <td class="text-center">2</td>
                                                        <td class="text-center">-2</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="position">
                                                            <div class="player-wrapper">
                                                                <span class="custom-badge custom-badge-lg is-square is-gk">GK</span>

                                                                <div>
                                                                    <a href="#" class="team-name link-nostyle">H Lloris</a>
                                                                    <br>
                                                                    <a href="#" class="player-name link-nostyle small">Tottenham</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">7.50</td>
                                                        <td class="text-center">17</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
                                                        <td class="text-center">0</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">3</td>
                                                        <td class="text-center">19</td>
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

@endsection

@push ('modals')
<div class="player-info-modal" id="players-info" tabindex="-1" role="dialog" aria-labelledby="players-info" aria-hidden="true">
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
                                    Player Detail
                                </li>
                                <li class="text-right">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-card-body">
            <div class="player-data-container">
                <div class="player-data-container-slim">
                    <div class="player-banner-wrapper">
                        <div class="player-banner-img">
                            <div class="player-banner-watermark">
                                <img class="player-banner-watermark-logo" src="{{ asset('assets/frontend/img/background/player-banner-bg.svg') }}" alt="">
                            </div>
                            <img class="player-crest" src="{{ asset('assets/frontend/img/status/player.jpg') }}" alt="">
                        </div>
                        <div class="player-banner-body">
                            <div class="player-wrapper-status">
                                <span>
                                    <img class="lazyload status-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/status/doubtful.svg') }}" alt="">
                                </span>
                                Doubtfull (illness)
                            </div>

                            <div class="link-nostyle squad-modal-stepper">
                                <div class="squad-modal-content">
                                    <div class="squad-modal-label">
                                        <div class="badge-area">
                                            <div class="custom-badge custom-badge-xl is-square is-fb">FB</div>
                                        </div>
                                    </div>
                                    <div class="squad-modal-body">
                                        <div class="squad-modal-title text-white">Luke Shaw</div>
                                        <div class="squad-modal-text text-white">Manchester United</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-12">
                            <ul class="nav nav-pills nav-justified theme-tabs theme-tabs-secondary m-1 f-12" id="pills-tab-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link px-1 active" id="PremierLeague-tab" data-toggle="pill" href="#PremierLeague" role="tab" aria-controls="PremierLeague" aria-selected="true">Premier League</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="FACup-tab" data-toggle="pill" href="#FACup" role="tab" aria-controls="FACup" aria-selected="false">FA Cup</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="History-tab" data-toggle="pill" href="#History" role="tab" aria-controls="History" aria-selected="false">History</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12">
                            <div class="tab-content" id="pills-tabContent-1">
                                <div class="tab-pane fade show active" id="PremierLeague" role="tabpanel" aria-labelledby="PremierLeague-tab">
                                    <div class="table-responsive">
                                        <table class="table text-center custom-table mb-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>PLD</th>
                                                    <th>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            GLS
                                                            <span class="custom-badge custom-badge-primary is-circle ml-1">G</span>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            ASS
                                                            <span class="custom-badge custom-badge-secondary is-circle ml-1">A</span>
                                                        </div>
                                                    </th>
                                                    <th>CS</th>
                                                    <th>GA</th>
                                                    <th>TOT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i=0; $i<30; $i++)
                                                    <tr>
                                                        <td class="text-dark">Home</td>
                                                        <td>5</td>
                                                        <td>1</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>8</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-dark">Away</td>
                                                        <td>6</td>
                                                        <td>0</td>
                                                        <td>2</td>
                                                        <td>1</td>
                                                        <td>12</td>
                                                        <td>0</td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>11</td>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>1</td>
                                                    <td>20</td>
                                                    <td>0</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="FACup" role="tabpanel" aria-labelledby="FACup-tab">

                                </div>
                                <div class="tab-pane fade" id="History" role="tabpanel" aria-labelledby="History-tab">

                                </div>
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
