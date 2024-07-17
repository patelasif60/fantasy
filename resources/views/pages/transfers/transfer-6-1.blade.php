@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script type="text/javascript" src="{{ asset('themes/codebase/js/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="row gutters-sm text-white">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="player">Player</label>
                                        <select class="js-player-select2" id="player">
                                            <option value="H Lloris (TOT) GK - Citizen Kane">H Lloris (TOT) GK - Citizen Kane</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="cash">+ Cash (£m)</label>
                                        <input type="text" class="form-control" id="cash" name="cash" placeholder="5">
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="player-transfer-icon text-white text-center">
                                <span><i class="far fa-arrow-down"></i></span>
                                <span><i class="far fa-arrow-up"></i></span>
                            </div> --}}

                            <div class="player-transfer-icon text-center">
                                <img src="{{ asset('assets/frontend/img/transfer/icon-swap-white.png')}}" alt="swap-icon">
                            </div>

                            <div class="row gutters-sm text-white">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="swap-player">Player</label>
                                        <select class="js-swap-player-select2" id="swap-player">
                                            <option value="Ederson (MC) GK - Richard's Team">Ederson (MC) GK - Richard's Team</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="cash">+ Cash (£m)</label>
                                        <input type="text" class="form-control" id="cash" name="cash" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 mb-5">
                                <div class="col-12">
                                    <p class="text-white mb-0">Citizen Kane will receive Ederson</p>
                                    <p class="text-white">Richard’s Team will receive H Lloris and £5m</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-body">
                    <div class="row mb-2 gutters-md">
                        <div class="col-6">
                            <button type="submit" class="btn btn-outline-white btn-block">Finished</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">Add swap</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        $(function () {
            $('.js-player-select2').select2();
            $('.js-swap-player-select2').select2();
        });
    </script>
@endpush

@push('footer-content')
    @include('partials.auth.footer')
@endpush



