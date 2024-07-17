@extends('layouts.auth.redesign')

@push('header-content')
    @include('partials.auth.header')
@endpush

@section('content')

    <div class="row align-items-center justify-content-center no-gutters">
        <div class="col-12">
            <div class="container-wrapper">
                <div class="container-body">
                    <div class="row mt-1 justify-content-center">
                        <div class="col-12 col-md-9">
                            <ul class="custom-list-group list-group-white">
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Team name</span>
                                            <span>Citizen Kane</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper"><span class="has-icon">Crest</span></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper"><span class="has-icon">Pitch</span></a>
                                    </div>
                                </li>
                            </ul>

                            <div class="row justify-content-center">
                                <div class="col-md-7 col-lg-5">
                                    <button type="submit" class="btn btn-danger btn-block">Remove your team from league</button>
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

@stack('page-scripts')


