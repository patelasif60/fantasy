@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-12 col-lg-9 col-xl-8">
            <div class="auth-card">
                <div class="auth-card-body padding-50">
                    <div class="row mb-3">
                        <div class="col-12 text-white">
                            <div class="form-group">
                                <label for="team-name">Team name</label>
                                <input type="text" class="form-control" id="team-name" name="team-name" placeholder="e.g Citizen Kane">
                            </div>
                        </div>
                    </div>
                    <div class="row team-creation">
                        <div class="col-md-6 col-lg-6">
                            <label class="text-white">Team crest</label>
                            <div class="team-selection">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio1">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio2">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio3">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio4">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio5" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio5">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio6" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio6">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio7" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio7">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio8" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio8">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio9" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio9">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio10" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio10">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio11" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio11">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio12" name="customRadio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio12">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                            </div>

                            <a href="#" class="btn btn-outline-white btn-block">
                                Upload Your Own Crest
                            </a>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <label class="text-white">Select a pitch</label>
                            <div class="pitch-selection">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio13" name="customRadio-pitch" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio13">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio14" name="customRadio-pitch" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio14">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio15" name="customRadio-pitch" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio15">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio16" name="customRadio-pitch" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio16">
                                        <img class="lazyload img-fluid team-crest-img" src="https://via.placeholder.com/300.png" alt="">
                                    </label>
                                </div>
                            </div>

                            <a href="#" class="btn btn-primary btn-block">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
