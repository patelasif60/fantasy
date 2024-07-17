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
                        <div class="col-12 text-white">
                            <div class="custom-media">
                                <div class="league-invitee mr-3">
                                    <img class="lazyload league-invitee-crest" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}">
                                </div>
                                <div class="custom-media-body">
                                    <p class="mb-0">You have been invited by Matt Simms to join <span class="league-name">‘The Magnificent Seven’</span></p>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="#" class="btn btn-primary btn-block">
                                Join League
                            </a>
                            <a href="#" class="btn btn-outline-white btn-block">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
