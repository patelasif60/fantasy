@extends('public-website.layouts.default')

@push('plugin-styles')
@endpush

@push('plugin-scripts')
@endpush

@push('page-scripts')
@endpush

@section('content')
<section class="hero-section hero-about">
    <div class="container-fluid">
        <div class="players-images bm-multiply js-carousel">
            <div class="pl-img-item" data-aos="fade-right" data-aos-duration="20" data-aos-offset="400" data-aos-disable="phone">
                <img class="lazyload" src="{{ asset('/frontend/img/players/Alan-Shearer_01_RGB.png') }}" data-src="{{ asset('/frontend/img/players/Alan-Shearer_01_RGB.png') }}" data-retina="{{ asset('/frontend/img/players/Alan-Shearer_01_RGB.png') }}" alt="Sergio Aguero">
            </div>
            <div class="pl-img-item" data-aos="fade-left" data-aos-delay="500" data-aos-offset="500" data-aos-duration="30" data-aos-disable="phone">
                <img class="lazyload" src="{{ asset('/frontend/img/players/Thierry-Henry_01_RGB.png') }}" data-src="{{ asset('/frontend/img/players/Thierry-Henry_01_RGB.png') }}" data-retina="{{ asset('/frontend/img/players/Thierry-Henry_01_RGB.png') }}" alt="Virgil Van">
            </div>
            <div class="pl-img-item" data-aos="fade-left" data-aos-delay="1000" data-aos-duration="500" data-aos-disable="phone">
                <img class="lazyload" src="{{ asset('/frontend/img/players/Ryan-Giggs_01_RGB.png') }}" data-src="{{ asset('/frontend/img/players/Ryan-Giggs_01_RGB.png') }}" data-retina="{{ asset('/frontend/img/players/Ryan-Giggs_01_RGB.png') }}" alt="Son Heung Min">
            </div>
        </div>

        <div class="shape-layer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-secondary" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>

        <div class="hero-block" data-aos="zoom-in-up" data-aos-offset="40">
            <h1 class="hero-title text-center">The</br>original</br>since</br>1991</h1>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row justify-content-center justify-content-lg-around">
            <div class="col-md-5 col-xl-4" data-aos="fade-right">
                <div class="keypoint-section">
                    <h4 class="keypoint-title">Early Days</h4>
                    <h6 class="keypoint-desc">Fantasy League created the UK’s first fantasy football game in 1991,<br class="d-none d-lg-block">a year before the launch of the Premier League.</h6>
                    <p class="keypoint-alt-desc d-none d-lg-block">Based around an auction format, a group of friends forms a league and bids against each other to create their own unique squads.</p>
                    <p class="keypoint-alt-desc d-none d-lg-block">It quickly picked up a cult following, inspiring the Fantasy League show on Radio5, before attracting the attention of The Daily Telegraph. We replaced the auction with a player price-list so the game could work for a mass audience.  It was a huge success with over 350,000 entrants, spurring all the other newspaper games and establishing the price-list format as the standard way to play fantasy football.</p>
                    <div class="star-group d-none d-lg-block"><span class="fl fl-stars"></span></div>
                </div>

                <div class="d-block d-lg-none">
                    <div class="collapse info-card-area read-more-wrapper" id="early-days">
                        <div class="info-card-block">
                            <div class="keypoint-section">
                                <p class="keypoint-alt-desc">Based around an auction format, a group of friends forms a league and bids against each other to create their own unique squads.</p>
                                <p class="keypoint-alt-desc">It quickly picked up a cult following, inspiring the Fantasy League show on Radio5, before attracting the attention of The Daily Telegraph. We replaced the auction with a player price-list so the game could work for a mass audience.  It was a huge success with over 350,000 entrants, spurring all the other newspaper games and establishing the price-list format as the standard way to play fantasy football.</p>
                                <div class="star-group"><span class="fl fl-stars"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="read-more-trigger">
                        <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#early-days" aria-expanded="false" aria-controls="early-days"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="img-combo" data-aos="fade-left" data-aos-delay="15">
                    <div class="img-wrapper is-newspaper" data-aos="fade-left" data-aos-delay="25">
                        <img class="lazyload section-img-wide" src="{{ asset('/frontend/img/other/Early-Days.png')}}" data-src="{{ asset('/frontend/img/other/Early-Days.png')}}" data-retina="{{ asset('/frontend/img/other/Early-Days.png')}}" alt="">
                    </div>
                    <div class="img-wrapper is-radio">
                        <img class="lazyload section-img-wide" src="{{ asset('/frontend/img/other/FL_About_Early-Days_Radio.png')}}" data-src="{{ asset('/frontend/img/other/FL_About_Early-Days_Radio.png')}}" data-retina="{{ asset('/frontend/img/other/FL_About_Early-Days_Radio.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="shape-layer left-col-shape-layer-1 parallax bm-multiply" data-paroller-factor="0.3"  data-paroller-factor-xs="0.3"  data-paroller-factor-sm="0.3"  data-paroller-type="foreground"  data-paroller-direction="horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-secondary" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>

    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row justify-content-center justify-content-lg-around">
            <div class="col-md-6 col-xl-7 order-last order-md-first" data-aos="fade-right">
                <div class="img-combo">
                    {{-- <div class="img-wrapper is-people">
                        <img class="lazyload section-img-wide" src="{{ asset('/frontend/img/other/Baddiel-&-Skinner_01.png')}}" data-src="{{ asset('/frontend/img/other/Baddiel-&-Skinner_01.png')}}" data-retina="{{ asset('/frontend/img/other/Baddiel-&-Skinner_01.png')}}" alt="">
                    </div>
                    <div class="img-wrapper is-mac">
                        <img class="lazyload section-img-wide" src="{{ asset('/frontend/img/other/About_IMac-G3_01.png')}}" data-src="{{ asset('/frontend/img/other/About_IMac-G3_01.png')}}" data-retina="{{ asset('/frontend/img/other/About_IMac-G3_01.png')}}" alt="">
                    </div> --}}
                    <div class="img-wrapper is-people-width-mac">
                        <img class="lazyload section-img-wide" src="{{ asset('/frontend/img/other/Baddiel-&-Skinner_01-Mac.png')}}" data-src="{{ asset('/frontend/img/other/Baddiel-&-Skinner_01-Mac.png')}}" data-retina="{{ asset('/frontend/img/other/Baddiel-&-Skinner_01-Mac.png')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-xl-4" data-aos="fade-left">
                <div class="keypoint-section">
                    <h4 class="keypoint-title">A GROWING EXPERTISE</h4>
                    <h6 class="keypoint-desc">Soon after we licensed the auction format to BBC2 for Baddiel & Skinner’s Fantasy Football League show and started to run newspaper games around the world.</h6>
                    <p class="keypoint-alt-desc d-none d-lg-block">By 1996 we had launched our first website and over the next 20 years provided games across a range of sports for The Times, BBC Sport, Scrum, Cricinfo, Sky Sports and The Sun.  Alongside this we continued to run our own games via fantasyleague.com and also created a Schools Fantasy Football League that ran successfully for over a decade.</p>
                    <div class="star-group d-none d-lg-block"><span class="fl fl-stars"></span></div>

                    <div class="d-block d-lg-none">
                        <div class="collapse info-card-area read-more-wrapper" id="growing-expertise">
                            <div class="info-card-block">
                                <div class="keypoint-section">
                                    <p class="keypoint-alt-desc">By 1996 we had launched our first website and over the next 20 years provided games across a range of sports for The Times, BBC Sport, Scrum, Cricinfo, Sky Sports and The Sun.  Alongside this we continued to run our own games via fantasyleague.com and also created a Schools Fantasy Football League that ran successfully for over a decade.</p>
                                    <div class="star-group"><span class="fl fl-stars"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="read-more-trigger">
                            <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#growing-expertise" aria-expanded="false" aria-controls="growing-expertise"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shape-layer ml-5 right-col-shape-layer-1 parallax bm-multiply" data-paroller-factor="-0.3"  data-paroller-factor-xs="0.3"  data-paroller-factor-sm="0.3"  data-paroller-type="foreground"  data-paroller-direction="horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-secondary" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>

    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row justify-content-center justify-content-lg-around align-items-center">
            <div class="col-md-5 col-xl-4 offset-xl-1" data-aos="fade-right">
                <div class="keypoint-section">
                    <h4 class="keypoint-title">FINDING OUT WHAT REALLY MATTERS</h4>
                    <h6 class="keypoint-desc">Throughout our journey, one thing always remained the best; the best game, the most engagement, the most loyal audience.</h6>
                    <p class="keypoint-alt-desc d-none d-lg-block">Our original, auction game - where 95% of the audience comes back year after year, and over 70% of leagues have been with us for more than 15 years.  Way ahead of any other game we’ve produced.</p>
                    <p class="keypoint-alt-desc d-none d-lg-block">So, in 2017 we resolved to make this game our single focus, and to pursue it with a passion.  With a completely rebuilt platform we’re ready show everyone why it’s the best way to play fantasy football, and why once you’ve experienced it, you never turn back.</p>
                    <div class="star-group d-none d-lg-block"><span class="fl fl-stars"></span></div>
                </div>

                <div class="d-block d-lg-none">
                    <div class="collapse info-card-area read-more-wrapper" id="important-matter">
                        <div class="info-card-block">
                            <div class="keypoint-section">
                                <p class="keypoint-alt-desc">Our original, auction game - where 95% of the audience comes back year after year, and over 70% of leagues have been with us for more than 15 years.  Way ahead of any other game we’ve produced.</p>
                                <p class="keypoint-alt-desc">So, in 2017 we resolved to make this game our single focus, and to pursue it with a passion.  With a completely rebuilt platform we’re ready show everyone why it’s the best way to play fantasy football, and why once you’ve experienced it, you never turn back.</p>
                                <div class="star-group"><span class="fl fl-stars"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="read-more-trigger">
                        <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#important-matter" aria-expanded="false" aria-controls="important-matter"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-6" data-aos="fade-left">
                <img class="lazyload section-img" src="{{ asset('/frontend/img/other/Android-Mobile_01.png')}}" data-src="{{ asset('/frontend/img/other/Android-Mobile_01.png')}}" data-retina="{{ asset('/frontend/img/other/Android-Mobile_01.png')}}" alt="">
            </div>
        </div>
        <div class="shape-layer ml-5 right-col-shape-layer-2 parallax bm-multiply" data-paroller-factor="0.3"  data-paroller-factor-xs="0.3"  data-paroller-factor-sm="0.3"  data-paroller-type="foreground"  data-paroller-direction="horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580">
                <polygon class="shear-shape is-secondary" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>

    </div>
</section>
@endsection

@push('modals')
@endpush
