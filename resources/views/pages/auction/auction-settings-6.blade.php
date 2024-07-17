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

                            <label class="text-white list-group-title">Round 1</label>

                            <ul class="custom-list-group list-group-white mb-4">
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Opening date and time</span>
                                            <span class="has-icon">1st Aug 19:00</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-element">
                                        <a href="#" class="has-stepper has-text">
                                            <span>Closing date and time</span>
                                            <span class="has-icon">2nd Aug 19:00</span>
                                        </a>
                                    </div>
                                </li>
                            </ul>

                            <div class="mb-4"><button type="submit" class="btn btn-primary btn-block">Add another round</button></div>

                            <p class="text-white">You can change the dates of a round any time before it has started. Typically, five rounds are required to complete an auction</p>

                            <p class="text-white">Automatic bid processing is enabled - if future rounds are no scheduled, they will be added automatically with a 24 hour duration.</p>
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
