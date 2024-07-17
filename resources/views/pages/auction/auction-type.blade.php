@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="custom-alert alert-tertiary">
                                <div class="alert-icon">
                                    <img src="{{ asset('assets/frontend/img/cta/icon-whistle.svg')}}" alt="alert-img">
                                </div>
                                <div class="alert-text">
                                    You can change these options at any point until your auction begins.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="cta-block-stepper">
                                <a href="#">Sealed Bids Auction</a>
                                <p>Managers can make sealed bids for as many  players as they need to.</p>
                            </div>

                            <div class="cta-block-stepper">
                                <a href="#">Traditional Auction</a>
                                <p>Managers bid for players in real time either face-to-face or online.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
