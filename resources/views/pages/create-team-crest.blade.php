@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-scripts')
    <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fileuploader/dist/jquery.fileuploader.min.js') }}" type="text/javascript"></script>
@endpush

@push('page-scripts')
    <script src="{{ asset('js/plugins/fileuploader/dist/custom.js') }}" type="text/javascript"></script>
@endpush

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <form action="" method="POST">
                <div class="container-wrapper">
                    <div class="container-body">
                        <div class="row mt-1">
                            <div class="col-12 text-white">
                                <div class="team-creation">
                                    <label class="text-white">Team crest</label>
                                    <div class="team-selection mb-3">
                                        <div class="row gutters-sm">
                                            <div class="col-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio1" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio1">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio2" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio2">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio3" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio3">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio4" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio4">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio5" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio5">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio6" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio6">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio7" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio7">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio8" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio8">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio9" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio9">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio10" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio10">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio11" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio11">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 col-lg-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="customRadio12" name="customRadio-crest" class="custom-control-input">
                                                    <label class="custom-control-label" for="customRadio12">
                                                        <img class="lazyload team-crest-img" src="{{ asset('assets/frontend/img/default/square/default-thumb-50.png')}}" data-src="{{ asset('assets/frontend/img/default/square/default-thumb.png')}}" alt="">
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
                                {{-- <a href="#" class="btn btn-outline-white btn-block" data-toggle="modal" data-target="#exampleModal">
                                    Upload Your Own Icon
                                </a> --}}
                                <div class="upload-crest">
                                    <input type="file" name="files">
                                </div>
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

