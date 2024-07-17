@extends('public-website.layouts.default')

@push('plugin-styles')
@endpush

@push('plugin-scripts')
@endpush

@push('page-scripts')
@endpush

@section('content')
<section class="hero-section">
    <div class="container-fluid">
        <div class="players-images bm-multiply js-carousel">
            <div class="pl-img-item" data-aos="fade-right" data-aos-duration="20" data-aos-offset="400" data-aos-disable="phone">
                <img class="lazyload" src="{{ asset('/frontend/img/players/Son-Heung-Min_01.png') }}" data-src="{{ asset('/frontend/img/players/Son-Heung-Min_01.png') }}" data-retina="{{ asset('/frontend/img/players/Son-Heung-Min_01.png') }}" alt="Son Heung Min">
            </div>
            <div class="pl-img-item" data-aos="fade-left" data-aos-delay="500" data-aos-offset="500" data-aos-duration="30" data-aos-disable="phone">
                <img class="lazyload" src="{{ asset('/frontend/img/players/Virgil-Van-Dijk_02.png') }}" data-src="{{ asset('/frontend/img/players/Virgil-Van-Dijk_02.png') }}" data-retina="{{ asset('/frontend/img/players/Virgil-Van-Dijk_02.png') }}" alt="Virgil Van">
            </div>
            <div class="pl-img-item" data-aos="fade-left" data-aos-delay="1000" data-aos-duration="500" data-aos-disable="phone">
                <img class="lazyload" src="{{ asset('/frontend/img/players/FL_Sergio-Aguero_03.png') }}" data-src="{{ asset('/frontend/img/players/FL_Sergio-Aguero_03.png') }}" data-retina="{{ asset('/frontend/img/players/FL_Sergio-Aguero_03.png') }}" alt="Sergio Aguero">
            </div>
        </div>

        <div class="shape-layer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-green" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>

        <div class="hero-block" data-aos="zoom-in-up" data-aos-offset="40">
            <h1 class="hero-title text-center">SET UP</br>YOUR</br>LEAGUE</br>NOW</h1>
        </div>
    </div>
</section>
<div class="action-area">
    <div class="container-fluid">
        <div class="d-flex justify-content-center">
            @auth
                @hasanyrole('superadmin|staff')
                    <a class="btn btn-secondary px-3"href="{{ route('admin.dashboard.index') }}">
                       <span>Go to dashboard</span>
                    </a>
                @endhasrole
                @hasrole('user')
                    <a class="btn btn-secondary px-3"href="{{ route('manage.division.teams.index') }}">
                       <span>Go to My League</span>
                    </a>
                @endhasrole
            @else
                <a href="{{ route('landing') }}" class="btn btn-outline-secondary px-5 mr-4 mr-md-5"><span>Sign up</span></a>
                <a href="{{ route('login') }}" class="btn btn-secondary px-5"><span>login</span></a>
            @endauth
        </div>
    </div>
</div>
<section>
    <div class="container-fluid">
        <div class="row justify-content-center justify-content-lg-around align-items-center">
            <div class="col-11 col-md-5 col-xl-3" data-aos="fade-right" data-aos-delay="20">
                <div class="keypoint-section">
                    <h2 class="keypoint-number">1</h2>
                    <h4 class="keypoint-title">CREATE YOUR OWN LEAGUE</h4>
                    <h6 class="keypoint-desc">Get your friends together.<br/>A WhatsApp group is perfect for this.</h6>
                    <div class="star-group"><span class="fl fl-stars"></span></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-6" data-aos="fade-left" data-aos-delay="15">
                <img class="lazyload section-img right-col-img right-col-img-1" src="{{ asset('/frontend/img/other/Create-Your-Own-League_Cut-Out_01.png')}}" data-src="{{ asset('/frontend/img/other/Create-Your-Own-League_Cut-Out_01.png')}}" data-retina="{{ asset('/frontend/img/other/Create-Your-Own-League_Cut-Out_01.png')}}" alt="">
            </div>
        </div>
        <div class="shape-layer left-col-shape-layer-2 parallax bm-multiply" data-paroller-factor="0.3" data-paroller-type="foreground"  data-paroller-direction="horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-green" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>

    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 col-xl-7 order-last order-md-first" data-aos="fade-right" data-aos-delay="20">
                <img class="lazyload section-img-wide left-col-img left-col-img-1" src="{{ asset('/frontend/img/other/Auction-BW_Cut-Out_01.png')}}" data-src="{{ asset('/frontend/img/other/Auction-BW_Cut-Out_01.png')}}" data-retina="{{ asset('/frontend/img/other/Auction-BW_Cut-Out_01.png')}}" alt="">
            </div>
            <div class="col-11 col-md-5 col-xl-3" data-aos="fade-left" data-aos-delay="15">
                <div class="keypoint-section">
                    <h2 class="keypoint-number">2</h2>
                    <h4 class="keypoint-title">Auction</h4>
                    <h6 class="keypoint-desc">Online or face-to-face.</br>Football meets poker, with beer.</h6>
                    <div class="star-group"><span class="fl fl-stars"></span></div>
                </div>
            </div>
        </div>
        <div class="shape-layer ml-5 left-col-shape-layer-3 parallax bm-multiply" data-paroller-factor="-0.3" data-paroller-type="foreground"  data-paroller-direction="horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-green" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>

    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 col-md-5 col-xl-3" data-aos="fade-right" data-aos-delay="20">
                <div class="keypoint-section">
                    <h2 class="keypoint-number">3</h2>
                    <h4 class="keypoint-title">Play</h4>
                    <h6 class="keypoint-desc">Unique squads, real transfer market, more competitive.</h6>
                    <div class="star-group"><span class="fl fl-stars"></span></div>
                </div>
            </div>
            <div class="col-md-6 col-xl-7" data-aos="fade-left" data-aos-delay="15">
                <img class="lazyload section-img right-col-img right-col-img-2" src="{{ asset('/frontend/img/other/Play_Cut-Out_01.png')}}" data-src="{{ asset('/frontend/img/other/Play_Cut-Out_01.png')}}" data-retina="{{ asset('/frontend/img/other/Play_Cut-Out_01.png')}}" alt="">
            </div>
        </div>
        <div class="shape-layer is-right-aligned right-col-shape-layer-3 parallax bm-multiply" data-paroller-factor="-0.3"  data-paroller-type="foreground"  data-paroller-direction="horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-green" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-xl-8 order-last order-md-first" data-aos="fade-right" data-aos-delay="20">
                <img class="lazyload section-img-wide left-col-img left-col-img-2" src="{{ asset('/frontend/img/other/Win_BW_Cut-Out.png')}}" data-src="{{ asset('/frontend/img/other/Win_BW_Cut-Out.png')}}" data-retina="{{ asset('/frontend/img/other/Win_BW_Cut-Out.png')}}" alt="">
            </div>
            <div class="col-11 col-md-5 col-xl-3" data-aos="fade-left" data-aos-delay="15">
                <div class="keypoint-section">
                    <h2 class="keypoint-number">4</h2>
                    <h4 class="keypoint-title">win</h4>
                    <h6 class="keypoint-desc">Outsmart your mates,</br>with Fantasy League victory is sweeter.</h6>
                    <div class="star-group"><span class="fl fl-stars"></span></div>
                </div>
            </div>
        </div>
        <div class="shape-layer is-right-aligned right-col-shape-layer-4 parallax bm-multiply" data-paroller-factor="-0.5"  data-paroller-type="foreground"  data-paroller-direction="horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-green" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>
    </div>
</section>
@endsection

@push('modals')
@endpush
