@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mb-100 mt-1">
                        <div class="col-12 text-white">
                            <a href="#" class="link-nostyle">
                                <div class="cta-block mt-2">
                                    <div class="league-image">
                                        <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/cta/badge-orange-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cta/badge-orange.png')}}" data-srcset="{{ asset('assets/frontend/img/cta/badge-orange.png')}} 1x, {{ asset('assets/frontend/img/cta/badge-orange@2x.png')}} 2x" alt="">
                                    </div>
                                    <div class="cta-wrapper">
                                        <p class="cta-title">Novice</p>
                                        <div class="cta-link-block">
                                            <div class="badge">FREE<small>/ PER TEAM</small></div>
                                        </div>
                                    </div>
                                    <div class="cta-wrapper">
                                        <div>
                                            <p class="cta-text text-dark">First season for free</p>
                                        </div>
                                        <div class="cta-link-block">
                                            <span>MORE INFO</span>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- <div class="cta-block mt-2">
                                <div class="league-image">
                                    <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/cta/badge-green-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cta/badge-green.png')}}" data-srcset="{{ asset('assets/frontend/img/cta/badge-green.png')}} 1x, {{ asset('assets/frontend/img/cta/badge-green@2x.png')}} 2x" alt="">
                                </div>
                                <div class="cta-wrapper">
                                    <p class="cta-title">Pro</p>
                                    <div class="cta-link-block">
                                        <div class="badge">£20/ <small>PER TEAM</small></div>
                                    </div>
                                </div>
                                <div class="cta-wrapper">
                                    <div>
                                        <p class="cta-text text-dark">Customise your league</p>
                                    </div>
                                    <div class="cta-link-block">
                                        <a href="#">MORE INFO</a>
                                    </div>
                                </div>
                            </div>

                            <div class="cta-block mt-2">
                                <div class="league-image">
                                    <img class="lazyload league-crest" src="{{ asset('assets/frontend/img/cta/badge-blue-thumb.png')}}" data-src="{{ asset('assets/frontend/img/cta/badge-blue.png')}}" data-srcset="{{ asset('assets/frontend/img/cta/badge-blue.png')}} 1x, {{ asset('assets/frontend/img/cta/badge-blue@2x.png')}} 2x" alt="">
                                </div>
                                <div class="cta-wrapper">
                                    <p class="cta-title">Legend</p>
                                    <div class="cta-link-block">
                                        <div class="badge">FREE<small>/ PER TEAM</small></div>
                                    </div>
                                </div>
                                <div class="cta-wrapper">
                                    <div>
                                        <p class="cta-text text-dark">Your game, your rules</p>
                                    </div>
                                    <div class="cta-link-block">
                                        <a href="#">MORE INFO</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-white text-center">
                            <p class="mb-3 f-14">Want to play with like-minded managers?<br> Create or join a <a href="#" class="text-white">social league</a> </p>
                        </div>
                        <div class="col-12">
                            <a href="#" class="btn btn-outline-white btn-block">
                                Join a League
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
