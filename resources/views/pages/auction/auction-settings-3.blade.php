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
                            <ul class="custom-list-group list-group-white">
                                <li>
                                    <div class="list-element">
                                        <a href="#"><span>Online sealed bids auction</span></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper"><span class="has-icon verified-data">Live online auction</span></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#"><span>Offline auction (manual entry)</span></a>
                                    </div>
                                </li>
                            </ul>
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
