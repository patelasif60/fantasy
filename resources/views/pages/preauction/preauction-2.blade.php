@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center no-gutters">
        <div class="col-12 bg-white">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="cta-block-preauction-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-9">
                                <div class="cta-block-preauction">
                                    <div class="league-image">
                                        <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/cta/badge-blue-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cta/badge-blue.png')}}" data-srcset="{{ asset('assets/frontend/img/cta/badge-blue.png')}} 1x, {{ asset('assets/frontend/img/cta/badge-blue@2x.png')}} 2x" alt="">
                                    </div>
                                    <div class="cta-wrapper">
                                        <div class="cta-detail">
                                            <p class="cta-title">Legend league</p>
                                            <div class="cta-link">
                                                <a href="#">League rules</a>
                                            </div>
                                        </div>
                                        <div class="cta-add-friend text-center">
                                            <div class="cta-link">
                                                <a href="#">
                                                    <div class="icon-add">
                                                        <img src="{{ asset('assets/frontend/img/auction/add-user.svg')}}" alt="add-icon">
                                                    </div>
                                                    Invite friend
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-11 col-md-8">
                            <div class="progress mt-3 mt-md-5">
                                <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress-status">4/7 teams have paid</div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-11 col-md-9">
                            <div class="auction-listing">
                                <div class="auction-list-group">
                                    @for ($i=0; $i<5; $i++)
                                    <div class="auction-list-group-item">
                                        <div class="auction-items">
                                            <div class="item">
                                                <div class="league-crest">
                                                    <img src="{{ asset('assets/frontend/img/league/league.svg')}}">
                                                </div>
                                                <div>
                                                    <div class="team-name">Richard's Team</div>
                                                    <div class="owner-name">Richard Stenson</div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="status is-paid">
                                                    <span><i class="fas fa-check-circle"></i></span>
                                                    <span class="status-text">Paid</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="auction-list-group-item list-group-item-action" href="#">
                                        <div class="auction-items">
                                            <div class="item">
                                                <div class="league-crest">
                                                    <img src="{{ asset('assets/frontend/img/league/league.svg')}}">
                                                </div>
                                                <div>
                                                    <div class="team-name">Richard's Team</div>
                                                    <div class="owner-name">Richard Stenson</div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="status is-unpaid">
                                                    <span><i class="fas fa-exclamation-circle"></i></span>
                                                    <span class="status-text">£30 Outstanding</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    @endfor
                                </div>
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

@stack('page-scripts')


