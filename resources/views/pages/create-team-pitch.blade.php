@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <form action="" method="POST">
                <div class="container-wrapper">
                    <div class="container-body">
                        <div class="row mt-1">
                            <div class="col-12 text-white">
                                <div class="team-creation">
                                    <label class="text-white">Select a pitch</label>
                                    <div class="pitch-selection mb-3">
                                        <div class="row gutter-sm">
                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio1" name="customRadio-pitch" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio1">
                                                        <img class="lazyload img-fluid" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio2" name="customRadio-pitch" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio2">
                                                        <img class="lazyload img-fluid" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio3" name="customRadio-pitch" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio3">
                                                        <img class="lazyload img-fluid" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio4" name="customRadio-pitch" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio4">
                                                        <img class="lazyload img-fluid" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="#" class="btn btn-primary btn-block">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
