@extends('public-website.layouts.default')

@push('plugin-styles')
@endpush

@push('plugin-scripts')
@endpush

@push('page-scripts')
@endpush

@section('content')
<section class="hero-section is-about">
    <div class="container-fluid">
        <div class="players-images">
            <div class="pl-img-item" data-aos="fade-right">
                <img src="{{ asset('/frontend/img/other/Referee_01.png') }}" alt="Referee">
            </div>
        </div>

        <div class="shape-layer is-horizontal bm-multiply">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 608.61 580" data-aos="fade-left">
                <polygon class="shear-shape is-green" points="383.53 580 608.61 0 225.08 0 0 580 383.53 580"/>
            </svg>
        </div>

        <div class="hero-block" data-aos="zoom-in-up" data-aos-offset="40">
            <h1 class="hero-title text-center">Game</br>Rules</h1>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7 col-xl-4" data-aos="fade-up">
                <div class="keypoint-section mb-5">
                    <h6 class="keypoint-desc">Fantasy League is the original game and how fantasy football was designed to be played.</h6>
                    <h6 class="keypoint-desc mb-5">Here's how the game works.</h6>
                    <h4 class="keypoint-title">SET UP YOUR LEAGUE</h4>
                    <h6 class="keypoint-desc">Start by setting up your league.</h6>
                    <p class="keypoint-alt-desc mb-5 d-none d-md-block">A WhatsApp group is perfect for this. Leagues can be from 5-16 managers and we recommend 8-12 as the sweet spot.</p>

                    <div class="d-block d-md-none">
                        <div class="collapse info-card-area read-more-wrapper" id="set-league">
                            <div class="info-card-block">
                                <p class="keypoint-alt-desc">A WhatsApp group is perfect for this. Leagues can be from 5-16 managers and we recommend 8-12 as the sweet spot.</p>
                            </div>
                        </div>
                        <div class="read-more-trigger">
                            <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#set-league" aria-expanded="false" aria-controls="set-league"></a>
                        </div>
                    </div>

                    <h4 class="keypoint-title">HOLD YOUR AUCTION</h4>
                    <h6 class="keypoint-desc">Fix a date for your auction and get everyone together, either online or face-to-face.</h6>
                    <p class="keypoint-alt-desc mb-5 d-none d-md-block">You each have a £200m budget to build your squad of 15, with a 2 players per club maximum. Each player goes to the highest bidder, so only one team gets Raheem Sterling - just like in the real world.</p>

                    <div class="d-block d-md-none">
                        <div class="collapse info-card-area read-more-wrapper" id="hold-auction">
                            <div class="info-card-block">
                                <p class="keypoint-alt-desc">You each have a £200m budget to build your squad of 15, with a 2 players per club maximum. Each player goes to the highest bidder, so only one team gets Raheem Sterling - just like in the real world.</p>
                            </div>
                        </div>
                        <div class="read-more-trigger">
                            <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#hold-auction" aria-expanded="false" aria-controls="hold-auction"></a>
                        </div>
                    </div>

                    <h4 class="keypoint-title">SCORING</h4>
                    <h6 class="keypoint-desc mb-3">Our simple scoring rules are tried-and-tested, as follows:</h6>
                    <h6 class="keypoint-desc">GOAL</h6>
                    <p class="keypoint-alt-desc text-center">3 points (all players)</p>
                    <h6 class="keypoint-desc">Assist</h6>
                    <p class="keypoint-alt-desc text-center">2 points (all players)</p>
                    <h6 class="keypoint-desc">Appearance</h6>
                    <p class="keypoint-alt-desc text-center">1 point (goalkeeper and defenders, 45+ mins)</p>
                    <h6 class="keypoint-desc">Clean Sheet</h6>
                    <p class="keypoint-alt-desc text-center">2 points (goalkeeper and defenders, 75+ mins)</p>
                    <h6 class="keypoint-desc">Goal Conceded</h6>
                    <p class="keypoint-alt-desc mb-5 text-center">-1 point (goalkeeper and defenders)</p>


                    <h4 class="keypoint-title">FORMATION & SUBS</h4>
                    <h6 class="keypoint-desc">Each week you have choices that really matter</h6>
                    <p class="keypoint-alt-desc mb-5 d-none d-md-block">One choice whether to play 442, 433, 532, 541 or 451, and another choice of who to leave on your bench. There are no backups, no second chances, no safety net. Pressure.</p>

                    <div class="d-block d-md-none">
                        <div class="collapse info-card-area read-more-wrapper" id="formation">
                            <div class="info-card-block">
                                <p class="keypoint-alt-desc">One choice whether to play 442, 433, 532, 541 or 451, and another choice of who to leave on your bench. There are no backups, no second chances, no safety net. Pressure.</p>
                            </div>
                        </div>
                        <div class="read-more-trigger">
                            <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#formation" aria-expanded="false" aria-controls="formation"></a>
                        </div>
                    </div>

                    <h4 class="keypoint-title">TRANSFERS</h4>
                    <h6 class="keypoint-desc">The game creates a real transfer market where everyone competes for players.</h6>
                    <p class="keypoint-alt-desc mb-5 d-none d-md-block">You have a £50m budget for the season and monthly transfer windows where you place sealed bids for free agents against your rivals. You can also negotiate swap deals with other managers.</p>

                    <div class="d-block d-md-none">
                        <div class="collapse info-card-area read-more-wrapper" id="transfer">
                            <div class="info-card-block">
                                <p class="keypoint-alt-desc">You have a £50m budget for the season and monthly transfer windows where you place sealed bids for free agents against your rivals. You can also negotiate swap deals with other managers.</p>
                            </div>
                        </div>
                        <div class="read-more-trigger">
                            <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#transfer" aria-expanded="false" aria-controls="transfer"></a>
                        </div>
                    </div>

                    <h4 class="keypoint-title">THE BEST WAY TO PLAY</h4>
                    <h6 class="keypoint-desc">As each squad is unique, your league is always ultra-competitive.</h6>
                    <p class="keypoint-alt-desc mb-5 d-none d-md-block">So, if you own Harry Kane, only you get the points when he scores. This means bigger points swings and leagues that stay close right through to the end of the season. Winning really means something.</p>

                    <div class="d-block d-md-none">
                        <div class="collapse info-card-area read-more-wrapper" id="way-to-play">
                            <div class="info-card-block">
                                <p class="keypoint-alt-desc">So, if you own Harry Kane, only you get the points when he scores. This means bigger points swings and leagues that stay close right through to the end of the season. Winning really means something.</p>
                            </div>
                        </div>
                        <div class="read-more-trigger">
                            <a class="collapse-action-btn" href="JavaScript:Void(0)"  data-toggle="collapse" data-target="#way-to-play" aria-expanded="false" aria-controls="way-to-play"></a>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <img class="img-fluid" src="{{ asset('/frontend/img/other/Whistle_01.png') }}" alt="Whistle">
                    </div>
                    <div class="star-group"><span class="fl fl-stars"></span></div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('modals')
@endpush
