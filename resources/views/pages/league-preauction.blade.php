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
                            <a class="custom-alert alert-tertiary" href="#">
                                <div class="alert-icon">
                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-red-card.svg') }}" alt="alert-img">
                                </div>
                                <div class="alert-text">
                                    Your team and others in your league are pending payment
                                </div>
                            </a>
                            <div class="custom-alert alert-tertiary">
                                <div class="alert-icon">
                                    <img  src="{{ asset('/assets/frontend/img/cta/icon-yellow-card.svg') }}" alt="alert-img">
                                </div>
                                <div class="alert-text">
                                    We need a few more details to finish setting up your account.
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
