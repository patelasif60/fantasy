@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
    <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/plugins/fileuploader/dist/custom.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('.team-carousel .owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                dots: true,
                autoplay: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    720: {
                        items: 1
                    },
                    1140: {
                        items: 1
                    }
                }
            });
        });
    </script>
@endpush

@section('content')

<div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-10">
        <div class="auth-card">
            <div class="auth-card-body">
                <div class="auth-card-content">
                    <div class="auth-card-header">
                        <div class="row">
                            <div class="col-12">
                                <ul class="top-navigation-bar">
                                    <li></li>
                                    <li class="text-center">Create a Team</li>
                                    <li class="text-right"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="auth-card-content-body">
                        <div class="row justify-content-center text-white">
                            <div class="col-12 col-md-11">
                                <div class="form-group">
                                    <label for="team-name">Your teams name</label>
                                    <input type="text" class="form-control" id="team-name" name="team-name" placeholder="Ben's Team">
                                </div>

                                <div class="team-creation team-carousel">
                                    <div class="team-selection owl-carousel owl-theme">

                                        <div class="item">
                                            <div class="row gutters-sm">
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio1" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio1">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio2" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio2">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio3" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio3">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio4" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio4">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio5" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio5">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio6" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio6">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio7" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio7">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio8" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio8">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio9" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio9">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio10" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio10">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio11" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio11">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio12" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio12">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio13" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio13">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio14" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio14">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio15" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio15">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio16" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio16">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio17" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio17">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio18" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio18">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <div class="row gutters-sm">
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio19" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio19">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio20" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio20">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio21" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio21">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio22" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio22">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio23" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio23">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio24" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio24">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio25" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio25">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio26" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio26">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio27" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio27">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio28" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio28">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio29" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio29">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio30" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio30">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio31" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio31">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio32" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio32">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio33" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio33">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio34" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio34">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio35" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio35">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio36" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio36">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <div class="row gutters-sm">
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio37" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio37">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio38" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio38">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio39" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio39">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio40" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio40">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio41" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio41">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio42" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio42">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio43" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio43">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio44" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio44">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio45" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio45">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio46" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio46">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio47" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio47">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio48" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio48">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio49" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio49">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio50" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio50">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio51" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio51">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio52" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio52">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio53" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio53">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-lg-2">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio54" name="customRadio-crest" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio54">
                                                            <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators align-items-center mb-0">
                                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="row gutters-sm">
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio1" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio1">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio2" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio2">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio3" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio3">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio4" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio4">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio5" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio5">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio6" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio6">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio7" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio7">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio8" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio8">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio9" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio9">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio10" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio10">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio11" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio11">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio12" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio12">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio13" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio13">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio14" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio14">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio15" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio15">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio16" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio16">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio17" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio17">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio18" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio18">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="row gutters-sm">
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio19" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio19">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio20" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio20">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio21" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio21">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio22" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio22">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio23" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio23">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio24" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio24">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio25" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio25">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio26" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio26">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio27" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio27">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio28" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio28">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio29" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio29">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio30" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio30">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio31" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio31">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio32" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio32">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio33" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio33">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio34" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio34">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio35" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio35">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio36" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio36">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="row gutters-sm">
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio37" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio37">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio38" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio38">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio39" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio39">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio40" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio40">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio41" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio41">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio42" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio42">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio43" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio43">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio44" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio44">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio45" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio45">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio46" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio46">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio47" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio47">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio48" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio48">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio49" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio49">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio50" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio50">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio51" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio51">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio52" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio52">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio53" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio53">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-3 col-lg-2">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio54" name="customRadio-crest" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio54">
                                                                    <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>

                                {{-- <script type="text/javascript">
                                    $(document).ready(function(){
                                      $("#carouselExampleIndicators").carousel();
                                        if ( $(window).width() < 640 ) {
                                           $('.col-4').unwrap().addClass('item');
                                           $('.col-4').addClass('active');
                                        }
                                    });
                                </script> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auth-card-content">
                    <div class="auth-card-footer">
                        <div class="row justify-content-center text-white mt-5">
                            <div class="col-12 col-md-11">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="upload-crest">
                                            <input type="file" name="files">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-block">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
