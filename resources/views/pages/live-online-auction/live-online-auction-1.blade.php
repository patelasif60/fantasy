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
                            <p class="text-white">Your league auction is scheduled to begin on 1st August 2019 at 19:00.</p>
                            <p class="text-white">The auction format is Live Online. You are nominated as the auctioneer.</p>
                            <p class="text-white">Once the auction is completed you will be able to manage your team.</p>
                        </div>
                    </div>
                </div>

                <div class="container-body">
                    <div class="mb-2"><button type="submit" class="btn btn-primary btn-block">Start auction now</button></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-content')
    @include('partials.auth.footer')
@endpush
