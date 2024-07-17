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
                                    Your request to join ‘The Magnificent Seven’ is pending approval by the league chief executive. You will be notified by email once your request has been approved.
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
